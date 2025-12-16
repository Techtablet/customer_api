<?php

namespace App\Http\Controllers\Api\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;

use Carbon\Carbon;

use Exception;

class ImportProductController extends Controller
{
    /**
     * Importer produit depuis l'ancienne base vers la nouvelle base
     *
     * @param Request $request
     * @return object
     **/
    public function importFromOldDbToNewDB(int $page = 1, int $productImported = 0, array $productError = [])
    {
        
        set_time_limit(600000);
        $productError = $productError;
        $url_dev = "https://dev.techtablet.fr/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url_prod = "https://www.techtablet.fr/services/customers/export_to_new_server/techtablet_sellers??page=$page";
        
        if (!isset($_REQUEST['continue'])) {
            dd("Attention!! Vérifier bien le lien de recuperation de produit. Ajoute le mot 'continue' dans l'url pour continuer l'importation");
        }
        if(!isset($_REQUEST['url']) || ($_REQUEST['url'] != 'dev' && $_REQUEST['url'] != 'prod')) {
            dd("Veuillez ajouter le paramètre 'url' dans l'url de la requête pour continuer l'importation. les valeurs possibles sont : 'dev' ou 'prod'. Par exemple : ?url=dev");
        }
        
        $url = $_REQUEST['url'] == 'dev' ? $url_dev : $url_prod;
        //dd($_REQUEST['url'], $url);
        $response = Http::get($url);
        
        if ($response->successful()) {
            $rateLimit = $response->header('x-ratelimit-limit');
            $remaining = $response->header('x-ratelimit-remaining');
            $reset = $response->header('x-ratelimit-reset');

            $responseJson = $response->json();
            $currentPage = $responseJson['data']['current_page'];
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $total = intval($responseJson['data']['total']);
            $data = $responseJson['data']['data'];

            if($data) {
                foreach($data as $k => $prd) {
                    DB::beginTransaction();
                    try {
                        

                        $productImported = $productImported + 1;
                        DB::commit();
                    } catch (\Throwable  $e) {
                        DB::rollBack();
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $productError = [
                            "id_product" => $prd['id_product'],
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : $response,
                        ];
                        dump("Erreur à la page " .$page);
                        dd($productError);
                        break;
                    }
                }
            }

            dump("Importation à ". round((intval($page) * 100) / $lastPage, 2) . " %");
            //dump(($productError));
            if ($nextPageUrl && count($productError) == 0) {
                $this->importFromOldDbToNewDB(intval($page) + 1, $productImported, $productError);
                die();
            }

            $return =  response()->json([
                'success' => count($productError) == 0 ? true : false,
                'message' => count($productError) == 0 ? "Opération réussite" : "Opération interrompue",
                'product_imported' => $productImported,
                'product_error' => $productError,
            ]);
            dump($return);
            die();
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                sleep($waitTime);
                $this->importFromOldDbToNewDB(intval($page), $productImported, $productError);
                die();
            }
            return response()->json(['error' => 'Unable to fetch data'], $response->status());
        }
    }

    public function checkBrandBeforImport(array $data) : object|null
    {
        $object = null;
        if ($data != null) {
            $object = Brand::where('id_brand', $data['id_brand'])->first();
            $fields = [
                "id_brand" => $data['id_brand'],
                "brand_name" => $data['brand_name'],
            ];
            if($object) {
                $object->update($fields);
            } else {
                $object = Brand::create($fields);
            }
        }
        return $object;
    }

    

}
