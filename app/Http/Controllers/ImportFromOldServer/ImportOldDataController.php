<?php

namespace App\Http\Controllers\ImportFromOldServer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Exception;

class ImportOldDataController extends Controller
{
    /**
     * Importer produit depuis l'ancienne base vers la nouvelle base
     *
     * @param Request $request
     * @return object
     **/
    public function importFromOldDbToNewDB()
    {
        
        set_time_limit(600000);
        
        $baseurl_dev = "https://dev.techtablet.fr";
        $baseurl_prod = "https://www.techtablet.fr";
        
        $baseurl = $baseurl_dev;
        
        $this->importTecthtabletData($baseurl, $page = 1);

    }

    public function importTecthtabletData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = []) : object|null
    {
        $for = 'techtablet_seller';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url = $baseUrl . $uri;

        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
            /*DB::beginTransaction();
            DB::commit();
            DB::rollBack();*/
            if($data) {
                dd($data);
                foreach($data as $k => $item) {
                    
                    try {
                        
                        $fillable = [
                            'id_techtablet_seller',
                            'first_name',
                            'last_name',
                            'primary_phone',
                            'secondary_phone',
                            'email',
                            'job_title',
                            'employee_code',
                            'digital_signature',
                            'is_active',
                        ];

                        $dataImported = $dataImported + 1;
                        
                    } catch (\Throwable  $e) {
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $dataError = [
                            "id_$for" => $item['id_techtablet_seller'],
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : $response,
                        ];
                        dump("Erreur à la page " .$page);
                        dd($dataError);
                        break;
                    }
                }
            }

            dump("Importation $for à ". round((intval($page) * 100) / $lastPage, 2) . " %");

            if ($nextPageUrl && count($dataError) == 0) {
                $this->importFromOldDbToNewDB(intval($page) + 1, $dataImported, $dataError);
                die();
            }

            $return =  response()->json([
                'success' => count($dataError) == 0 ? true : false,
                'message' => count($dataError) == 0 ? "Opération réussite" : "Opération interrompue",
                'product_imported' => $dataImported,
                'product_error' => $dataError,
            ]);
            dump($return);
            die();
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                sleep($waitTime);
                $this->importFromOldDbToNewDB(intval($page), $dataImported, $dataError);
                die();
            }
            die(response()->json(['error' => 'Unable to fetch data'], $response->status()));
        }

        return $object;
    }

    

}
