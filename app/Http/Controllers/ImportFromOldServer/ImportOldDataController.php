<?php

namespace App\Http\Controllers\ImportFromOldServer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TechtabletSellerController;
use App\Http\Requests\TechtabletSellerRequest\StoreTechtabletSellerRequest;
use App\Http\Requests\TechtabletSellerRequest\UpdateTechtabletSellerRequest;
use App\Models\TechtabletSeller;
use App\Models\StoreGroup;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        DB::beginTransaction();
        try {
            $d = $this->importTechtabletSellerData($baseurl, $page = 1);
            DB::commit();
            dd("Fin import");
        } catch (\Throwable $th) {
            DB::rollBack();
            dump($th);
            dd("ERROR");
        }

    }

    public function importTechtabletSellerData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'techtablet_seller';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url = $baseUrl . $uri;
        $techtabletSellerController = new TechtabletSellerController();
        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$item['id_seller']}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [
                            'id_techtablet_seller' => $item['id_seller'],
                            'first_name' => $item['name'],
                            'last_name' => $item['lastname'],
                            'phone1' => $item['phone1'],
                            'phone2' => $item['phone2'],
                            'email' => $item['email'],
                            'post' => $item['post'],
                            'key' => $item['key'],
                            'signature' => $item['sign'],
                            'is_active' => $item['active'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = TechtabletSeller::where('id_techtablet_seller', $item['id_seller'])->first();

                        // Créer une requête avec les données mappées
                        $request = new Request($mappedData);
                        
                        if ($existingSeller) {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new UpdateTechtabletSellerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());
                            
                            dump("🔄 Vendeur mis à jour: {$item['name']} {$item['lastname']} (ID: {$item['id_seller']})");
                        } else {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new StoreTechtabletSellerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Créer avec les données validées
                            TechtabletSeller::create($validator->validated());
                            
                            dump("✅ Vendeur créé: {$item['name']} {$item['lastname']} (ID: {$item['id_seller']})");
                        }
                        
                        $dataImported = $dataImported + 1;
                        
                    } catch (\Throwable  $e) {
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $dataError = [
                            "id_$for" => $item['id_seller'] ?? 'unknown',
                            "name" => ($item['name'] ?? '') . ' ' . ($item['lastname'] ?? ''),
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : (string)$response,
                        ];
                        throw new \Exception($erreurExceptionMessage . $dataError['message'] ?? 'Erreur inconnue', 0, $e);
                    }
                }
            }

            dump("Importation $for à ". round((intval($page) * 100) / $lastPage, 2) . " %");

            if ($nextPageUrl && count($dataError) == 0) {
                return $this->importTechtabletSellerData($baseUrl, intval($page) + 1, $dataImported, $dataError);
            }

            $return =  [
                'success' => count($dataError) == 0 ? true : false,
                'message' => count($dataError) == 0 ? "Opération réussite" : "Opération interrompue",
                'data_imported' => $dataImported,
                'data_error' => $dataError,
            ];
            return $return;
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                dump("⏳ Rate limit atteint, attente de {$waitTime}s...");
                sleep($waitTime);
                return $this->importTechtabletSellerData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }

    public function importStoreGroupData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'techtablet_seller';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/techtablet_sellers?page=$page";
        $url = $baseUrl . $uri;
        $techtabletSellerController = new TechtabletSellerController();
        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$item['id_seller']}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [
                            'id_techtablet_seller' => $item['id_seller'],
                            'first_name' => $item['name'],
                            'last_name' => $item['lastname'],
                            'phone1' => $item['phone1'],
                            'phone2' => $item['phone2'],
                            'email' => $item['email'],
                            'post' => $item['post'],
                            'key' => $item['key'],
                            'signature' => $item['sign'],
                            'is_active' => $item['active'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = TechtabletSeller::where('id_techtablet_seller', $item['id_seller'])->first();

                        // Créer une requête avec les données mappées
                        $request = new Request($mappedData);
                        
                        if ($existingSeller) {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new UpdateTechtabletSellerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());
                            
                            dump("🔄 Vendeur mis à jour: {$item['name']} {$item['lastname']} (ID: {$item['id_seller']})");
                        } else {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new StoreTechtabletSellerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Créer avec les données validées
                            TechtabletSeller::create($validator->validated());
                            
                            dump("✅ Vendeur créé: {$item['name']} {$item['lastname']} (ID: {$item['id_seller']})");
                        }
                        
                        $dataImported = $dataImported + 1;
                        
                    } catch (\Throwable  $e) {
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $dataError = [
                            "id_$for" => $item['id_seller'] ?? 'unknown',
                            "name" => ($item['name'] ?? '') . ' ' . ($item['lastname'] ?? ''),
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : (string)$response,
                        ];
                        throw new \Exception($erreurExceptionMessage . $dataError['message'] ?? 'Erreur inconnue', 0, $e);
                    }
                }
            }

            dump("Importation $for à ". round((intval($page) * 100) / $lastPage, 2) . " %");

            if ($nextPageUrl && count($dataError) == 0) {
                return $this->importTechtabletSellerData($baseUrl, intval($page) + 1, $dataImported, $dataError);
            }

            $return =  [
                'success' => count($dataError) == 0 ? true : false,
                'message' => count($dataError) == 0 ? "Opération réussite" : "Opération interrompue",
                'data_imported' => $dataImported,
                'data_error' => $dataError,
            ];
            return $return;
        } else {
            if ($response->status() === 429) {
                $waitTime = $response->header('Retry-After', 60); // Temps d'attente par défaut de 60 secondes
                dump("⏳ Rate limit atteint, attente de {$waitTime}s...");
                sleep($waitTime);
                return $this->importTechtabletSellerData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }
}