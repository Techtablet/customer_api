<?php

namespace App\Http\Controllers\ImportFromOldServer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

use App\Http\Controllers\Api\TechtabletSellerController;
use App\Http\Requests\TechtabletSellerRequest\StoreTechtabletSellerRequest;
use App\Http\Requests\TechtabletSellerRequest\UpdateTechtabletSellerRequest;
use App\Models\TechtabletSeller;

use App\Http\Controllers\Api\StoreGroupController;
use App\Http\Requests\StoreGroupRequest\StoreStoreGroupRequest;
use App\Http\Requests\StoreGroupRequest\UpdateStoreGroupRequest;
use App\Models\StoreGroup;

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
            dump("Début import Techtablet Sellers");
            $d = $this->importTechtabletSellerData($baseurl, $page = 1);
            dump("Fin import Techtablet Sellers");
            
            dump("Début import Store Groups");
            $d = $this->importStoreGroupData($baseurl, $page = 1);
            dump("Fin import Store Groups");

            dump("Début import Customers");
            //$d = $this->importCustomerData($baseurl, $page = 1);
            dump("Fin import Customers");
            
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
        $for = 'store_groups';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/store_groups?page=$page";
        $url = $baseUrl . $uri;
        $storeGroupController = new StoreGroupController();
        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id_group'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [
                            'id_store_group' => $item['id_group'],
                            'group_name' => $item['group_name'],
                            'group_key' => $item['group_key'],
                            'group_logo' => $item['group_logo'],
                            'first_name' => $item['name'],
                            'last_name' => $item['lastname'],
                            'is_sepa' => $item['is_sepa'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = StoreGroup::where('id_store_group', $item['id_group'])->first();

                        // Créer une requête avec les données mappées
                        $request = new Request($mappedData);
                        
                        if ($existingSeller) {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new UpdateStoreGroupRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new StoreStoreGroupRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Créer avec les données validées
                            StoreGroup::create($validator->validated());
                            
                            dump("✅ Item créé: ID {$idItem}");
                        }
                        
                        $dataImported = $dataImported + 1;
                        
                    } catch (\Throwable  $e) {
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $dataError = [
                            "id_$for" => $idItem,
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : (string)$response,
                        ];
                        throw new \Exception($erreurExceptionMessage . $dataError['message'] ?? 'Erreur inconnue', 0, $e);
                    }
                }
            }

            dump("Importation $for à ". round((intval($page) * 100) / $lastPage, 2) . " %");

            if ($nextPageUrl && count($dataError) == 0) {
                return $this->importStoreGroupData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importStoreGroupData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }

    public function importCustomerData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'store_groups';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/store_groups?page=$page";
        $url = $baseUrl . $uri;
        $storeGroupController = new StoreGroupController();
        $response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id_group'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [
                            'id_store_group' => $item['id_group'],
                            'group_name' => $item['group_name'],
                            'group_key' => $item['group_key'],
                            'group_logo' => $item['group_logo'],
                            'first_name' => $item['name'],
                            'last_name' => $item['lastname'],
                            'is_sepa' => $item['is_sepa'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = StoreGroup::where('id_store_group', $item['id_group'])->first();

                        // Créer une requête avec les données mappées
                        $request = new Request($mappedData);
                        
                        if ($existingSeller) {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new UpdateStoreGroupRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new StoreStoreGroupRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Créer avec les données validées
                            StoreGroup::create($validator->validated());
                            
                            dump("✅ Item créé: ID {$idItem}");
                        }
                        
                        $dataImported = $dataImported + 1;
                        
                    } catch (\Throwable  $e) {
                        $response = method_exists($e, 'getResponse') ? $e->getResponse() : $e;
                        $dataError = [
                            "id_$for" => $idItem,
                            "message" => method_exists($response, 'getMessage') ? $response->getMessage() : (string)$response,
                        ];
                        throw new \Exception($erreurExceptionMessage . $dataError['message'] ?? 'Erreur inconnue', 0, $e);
                    }
                }
            }

            dump("Importation $for à ". round((intval($page) * 100) / $lastPage, 2) . " %");

            if ($nextPageUrl && count($dataError) == 0) {
                return $this->importStoreGroupData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importStoreGroupData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }
}