<?php

namespace App\Http\Controllers\Api\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;

use Carbon\Carbon;

use Exception;

class ImportOldDataController extends Controller
{
    /**
     * Importer données depuis l'ancienne base vers la nouvelle base
     *
     * @param Request $request
     * @return object
     **/
    public function importFromOldDbToNewDB(int $page = 1, int $dataImported = 0, array $datatError = [])
    {
        
        set_time_limit(600000);
        $datatError = $datatError;
        $url_dev = "https://dev.techtablet.fr/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url_prod = "https://www.techtablet.fr/services/customers/export_to_new_server/techtablet_sellers??page=$page";
        
        if (!isset($_REQUEST['continue'])) {
            dd("Attention!! Vérifier bien le lien de recuperation de data. Ajoute l'attribut 'continue' dans l'url pour continuer l'importation");
        }
        if(!isset($_REQUEST['url']) || ($_REQUEST['url'] != 'dev' && $_REQUEST['url'] != 'prod')) {
            dd("Veuillez ajouter le paramètre 'url' dans l'url de la requête pour continuer l'importation. les valeurs possibles sont : 'dev' ou 'prod'. Par exemple : ?url=dev");
        }
        
        $url = $_REQUEST['url'] == 'dev' ? $url_dev : $url_prod;
        //dd($_REQUEST['url'], $url);
        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $data = $responseJson['data']['data'];

            if($data) {
                foreach($data as $k => $prd) {
                    DB::beginTransaction();
                    try {
                        

                        $dataImported = $dataImported + 1;
                        DB::commit();
                    } catch (\Throwable  $e) {
                        DB::rollBack();
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $datatError = [
                            "id_product" => $prd['id_product'],
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : $response,
                        ];
                        dump("Erreur à la page " .$page);
                        dd($datatError);
                        break;
                    }
                }
            }

            dump("Importation à ". round((intval($page) * 100) / $lastPage, 2) . " %");
            
            if ($nextPageUrl && count($datatError) == 0) {
                $this->importFromOldDbToNewDB(intval($page) + 1, $dataImported, $datatError);
                die();
            }

            $return =  response()->json([
                'success' => count($datatError) == 0 ? true : false,
                'message' => count($datatError) == 0 ? "Opération réussite" : "Opération interrompue",
                'product_imported' => $dataImported,
                'product_error' => $datatError,
            ]);
            dump($return);
            return $return;
            die();
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                sleep($waitTime);
                $this->importFromOldDbToNewDB(intval($page), $dataImported, $datatError);
                die();
            }
            dd(response()->json(['error' => 'Unable to fetch data'], $response->status()));
        }
    }

    public function importTechtabletSeller(string $baseUrl, int $page, int $dataImported = 0, array $datatError = []) : object|null
    {
        $uri = "/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url = $baseUrl . $uri;
        $response = Http::get($url);
        $object = null;
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $data = $responseJson['data']['data'];

            if($data) {
                foreach($data as $k => $prd) {
                    DB::beginTransaction();
                    try {
                        

                        $dataImported = $dataImported + 1;
                        DB::commit();
                    } catch (\Throwable  $e) {
                        DB::rollBack();
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $datatError = [
                            "id_product" => $prd['id_product'],
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : $response,
                        ];
                        dump("Erreur à la page " .$page);
                        dd($datatError);
                        break;
                    }
                }
            }

            dump("Importation à ". round((intval($page) * 100) / $lastPage, 2) . " %");
            
            if ($nextPageUrl && count($datatError) == 0) {
                $this->importFromOldDbToNewDB(intval($page) + 1, $dataImported, $datatError);
                die();
            }

            $return =  response()->json([
                'success' => count($datatError) == 0 ? true : false,
                'message' => count($datatError) == 0 ? "Opération réussite" : "Opération interrompue",
                'product_imported' => $dataImported,
                'product_error' => $datatError,
            ]);
            dump($return);
            return $return;
            die();
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                sleep($waitTime);
                $this->importFromOldDbToNewDB(intval($page), $dataImported, $datatError);
                die();
            }
            dd(response()->json(['error' => 'Unable to fetch data'], $response->status()));
        }

        return $object;
    }

    

}
