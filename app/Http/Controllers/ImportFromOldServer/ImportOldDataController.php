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

use App\Http\Requests\CustomerRequest\StoreCustomerRequest;
use App\Http\Requests\CustomerRequest\UpdateCustomerRequest;
use App\Models\Customer;

use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Models\User;

use \App\Http\Requests\CustomerComptaRequest\StoreCustomerComptaRequest;
use \App\Http\Requests\CustomerComptaRequest\UpdateCustomerComptaRequest;
use \App\Models\CustomerCompta;

use \App\Http\Requests\CustomerStatRequest\StoreCustomerStatRequest;
use \App\Http\Requests\CustomerStatRequest\UpdateCustomerStatRequest;
use \App\Models\CustomerStat;

use App\Http\Requests\CustomerAddressRequest\StoreCustomerAddressRequest;
use App\Http\Requests\CustomerAddressRequest\UpdateCustomerAddressRequest;
use App\Models\CustomerAddress;
use App\Models\CustomerCountry;

use App\Http\Requests\InvoiceAddressRequest\StoreInvoiceAddressRequest;
use App\Http\Requests\InvoiceAddressRequest\UpdateInvoiceAddressRequest;
use App\Models\InvoiceAddress;

use App\Http\Requests\ShippingAddressRequest\StoreShippingAddressRequest;
use App\Http\Requests\ShippingAddressRequest\UpdateShippingAddressRequest;
use App\Models\ShippingAddress;

use App\Http\Requests\CustomerContactRequest\StoreCustomerContactRequest;
use App\Http\Requests\CustomerContactRequest\UpdateCustomerContactRequest;
use App\Models\CustomerContact;

use App\Http\Requests\CustomerContactProfileRequest\StoreCustomerContactProfileRequest;
use App\Http\Requests\CustomerContactProfileRequest\UpdateCustomerContactProfileRequest;
use App\Models\CustomerContactProfile;

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
        ini_set('max_execution_time', 0);     // ou set_time_limit(0);
        ini_set('max_input_time', -1);        // -1 = illimité
        ini_set('memory_limit', '-1');        // -1 = illimité
        set_time_limit(0);
        
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
            $d = $this->importCustomerData($baseurl, $page = 1);
            dump("Fin import Customers");

            dump("Début import Shipping Addresses");
            $d = $this->importShippingAddressData($baseurl, $page = 1);
            dump("Fin import Shipping Addresses");

            dump("Début import customer Contacts");
            $d = $this->importCustomerContactData($baseurl, $page = 1);
            dump("Fin import customer Contacts");

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
        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);
        
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
                            TechtabletSeller::create(array_merge($validator->validated(), ['id_techtablet_seller' => $item['id_seller']]));
                            
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
        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);
        
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
                            $existingSeller->update(array_merge($validator->validated(), ['id_store_group' => $item['id_group']]));
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new StoreStoreGroupRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Créer avec les données validées
                            StoreGroup::create(array_merge($validator->validated(), ['id_store_group' => $item['id_group']]));
                            
                            dump("✅ $for Item créé: ID {$idItem}");
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
        $for = 'customers';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/customers?page=$page";
        $url = $baseUrl . $uri;

        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);

        //$response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id_customer'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [
                            'user_infos' => [
                                'id_user' => $item['id_customer'],
                                'type' => 'customer',
                                'email' => $item['id_customer'] . $item['email'],
                                'user_key' => $item['key'] == "" ? null : $item['key'],
                                'password' => "123456789",
                            ],

                            'id_customer' => $item['id_customer'],
                            'name' => $item['name'],
                            'siren' => $item['siren'],
                            'siret' => $item['siret'],
                            'newsletter' => $item['newsletter'],
                            'already_called' => $item['alreadycalled'],

                            'id_franchise' => $item['franchise'] == 0 ? null : $item['franchise'],
                            'id_stock_software' => $item['stock_software'] == "0" ? null : $item['stock_software'],
                            'to_callback' => $item['to_callback'],
                            'id_status' => $item['status'],
                            'id_refusal_reason' => $item['refusal_reason'] == "0" ? null : $item['refusal_reason'],

                            'survey_actif' => $item['survey_actif'],
                            'survey_date_disabled' => $item['survey_date_disabled'] == "0000-00-00" ? null : $item['survey_date_disabled'],
                            'important' => $item['important'],
                            'notes' => $item['notes'],
                            'reminder' => $item['reminder'] == "0000-00-00 00:00:00" || $item['reminder'] == "0000-00-00" ? null : $item['reminder'],
                            'seller_reminder' => $item['seller_reminder'],

                            'id_seller' => intval($item['id_seller']) == 0 ? null : intval($item['id_seller']),
                            'repurchase_menu' => $item['repurchase_menu'],
                            'dropshipping_menu' => $item['dropshipping_menu'],
                            'dropshipping_fee' => $item['dropshipping_fee'],
                            'delivery_order' => $item['delivery_order'],
                            'profil' => $item['profil'],

                            'information_request_send' => $item['information_request_send'],
                            'information_request_validated' => $item['information_request_validated'],
                            'information_request_validated_once' => $item['information_request_validated_once'],
                            'ape' => $item['ape'],
                            'rcs' => $item['rcs'],
                            'tourist_area' => $item['tourist_area'],
                            
                            'denomination' => $item['denomination'],
                            'id_store_group' => intval($item['id_group']) == 0 ? null : intval($item['id_group']),
                            'shipping_schedule' => $item['shipping_schedule'] == "" ? null : $item['shipping_schedule'],
                            'has_customer_order_number' => $item['has_customer_order_number'],
                            'last_website_key' => $item['last_website_key'],
                            'receive_stock_software_file' => $item['receive_stock_software_file'],

                            'stock_software_file_format' => $item['stock_software_file_format'],
                            'supplier_id_for_techtablet' => $item['supplier_id_for_techtablet'],
                            'internal_customer_id' => $item['internal_customer_id'],
                            'id_lang' => $item['id_lang'],
                            'id_shipping_plan' => $item['id_shippingplan'],
                            'id_price_list_info' => $item['id_price_list_info'],

                            'id_location' => intval($item['id_location']) == 0 ? null : intval($item['id_location']),
                            'id_typology' => intval($item['id_typology']) == 0 ? null : intval($item['id_typology']),
                            'id_canvassing_step' => intval($item['id_canvassing']) == 0 ? null : intval($item['id_canvassing']),
                            'refund_by_ic' => $item['refund_by_ic'],
                            'repurchase_type' => $item['repurchase_type'],
                            'inactive' => $item['inactive'],
                            'receive_credit_on_reprise_stock_validation' => $item['receive_credit_on_reprise_stock_validation'],
                            'featured_product' => $item['featured_product'],

                            'compta_infos' => [
                                'id_customer_compta' => $item['id_customer'],
                                'id_customer' => $item['id_customer'],
                                'devise' => $item['devise'],
                                'tva_intra_number' => $item['tva_intra_number'],
                                'payment_mode' => $item['payment_mode'],
                                'rib_etablissement' => $item['rib_etablissement'],

                                'rib_guichet' => $item['rib_guichet'],
                                'rib_compte' => $item['rib_compte'],
                                'rib_cle' => $item['rib_cle'],
                                'discount' => $item['discount'],
                                'balance' => $item['balance'],
                                'shipping_invoice' => $item['shipping_invoice'],

                                'en_cours' => $item['en_cours'],
                                'future_payment_mode' => $item['future_payment_mode'],
                                'future_payment_delay_type' => $item['future_payment_delay_type'],
                                'future_payment_delay' => $item['future_payment_delay'],
                                'rolling_period_days' => $item['rolling_period_days'],
                                'rolling_period_amount' => $item['rolling_period_amount'],

                                'rolling_period_cron_date' => $item['rolling_period_cron_date'],
                                'bic' => $item['bic'],
                                'iban' => $item['iban'],
                                'grouped_invoice' => intval($item['grouped_invoice']) == 0 ? false : true,
                                'grouped_invoice_begin' => $item['grouped_invoice_begin'] == "0000-00-00" ? null : $item['grouped_invoice_begin'],
                                'grouped_invoice_end' => $item['grouped_invoice_end'] == "0000-00-00" ? null : $item['grouped_invoice_end'],

                                'cb_register_info' => $item['cb_register_info'],
                                'cb_register_always_ask' => $item['cb_register_always_ask'],
                                'cb_token' => $item['cb_token'],
                                'cb_date_val' => $item['cb_date_val'],
                                'cb_ref_abonne' => $item['cb_ref_abonne'],
                                'sepa_mandat_reference' => $item['sepa_mandat_reference'],

                                'sepa_payment_type' => $item['sepa_payment_type'],
                                'sepa_debtor_name' => $item['sepa_debtor_name'],
                                'sepa_debtor_address' => $item['sepa_debtor_address'],
                                'sepa_debtor_address_pc' => $item['sepa_debtor_address_pc'],
                                'sepa_debtor_address_city' => $item['sepa_debtor_address_city'],
                                'sepa_signature_location' => $item['sepa_signature_location'],

                                'sepa_signature_date' => $item['sepa_signature_date'] == "0000-00-00" ? null : $item['sepa_signature_date'],
                                'sepa_request_validated' => $item['sepa_request_validated'],
                                'sepa_request_validated_once' => $item['sepa_request_validated_once'],
                                'is_blprice' => $item['is_blprice'],
                                'classic_invoice' => $item['classic_invoice'],
                            ],

                            'stat_infos' => [
                                'id_customer_stat' => $item['id_customer'],
                                'id_customer' => $item['id_customer'],
                                'arevage_ordervalue' => $item['arevage_ordervalue'],
                                'last_order' => $item['last_order'] == "0000-00-00 00:00:00" || $item['last_order'] == '0000-00-00' ? null : $item['last_order'],
                                'first_order' => $item['first_order'] == "0000-00-00 00:00:00" || $item['first_order'] == '0000-00-00' ? null : $item['first_order'],
                                'profitability' => $item['profitability'],

                                'profitabilityOneYear' => $item['profitabilityOneYear'],
                                'profitabilityThreeMonth' => $item['profitabilityThreeMonth'],
                                'turnover' => $item['turnover'],
                                'turnoverOneYear' => $item['turnoverOneYear'],
                                'turnoverThreeMonth' => $item['turnoverThreeMonth'],

                                'point1' => $item['point1'],
                                'point2' => $item['point2'],
                                'point3' => $item['point3'],
                                'point4' => $item['point4'],
                                'point5' => $item['point5'],
                                'point6' => $item['point6'],
                                'point7' => $item['point7'],
                                'point8' => $item['point8'],
                                'point9' => $item['point9'],
                                'point10' => $item['point10'],
                                'point11' => $item['point11'],
                                'point12' => $item['point12'],
                                'point13' => $item['point13'],

                                'profitability_lifepercent' => $item['profitability_lifepercent'],
                                'profitability_yearrpercent' => $item['profitability_yearrpercent'],
                                'profitability_threepercent' => $item['profitability_threepercent'],
                                'promise_of_order_added' => $item['promise_of_order_added'] == "0000-00-00 00:00:00" || $item['promise_of_order_added'] == '0000-00-00' ? null : $item['promise_of_order_added'],
                                'promise_of_order' => $item['promise_of_order'] == "0000-00-00 00:00:00" || $item['promise_of_order'] == '0000-00-00' ? null : $item['promise_of_order'],
                            ],
                        ];

                        if ($item['adressef'] && $item['adressef'] != '' && $item['adressef_pc'] && $item['adressef_pc'] != '') {
                            $mappedData['invoice_address_infos'] = [
                                'id_invoice_address' => $item['id_customer'],
                                //'id_customer_address',
                                'id_customer' => $item['id_customer'],
                                'email' => $item['adressef_email'],
                            ];
                            $mappedData['invoice_address_infos']['address_infos'] = [
                                'id_customer_address' => $item['id_customer'],
                                'first_name' => $item['firstnamef'],
                                'last_name' => $item['lastnamef'],
                                'address' => $item['adressef'],
                                'complement_address' => '',
                                'postal_code' => $item['adressef_pc'],
                                'city' => $item['adressef_ville'],
                                'id_country' => CustomerCountry::where('name', $item['adressef_pays'])->orWhere('name_en', $item['adressef_pays'])->orWhere('name_de', $item['adressef_pays'])->value('id_customer_country'),
                                'phone' => $item['adressef_phone'] == '' ? null : $item['adressef_phone'],
                                'fax' => $item['adressef_fax'],
                                'longitude' => $item['adressef_lng'],
                                'latitude' => $item['adressef_lat'],
                                'place_id' => $item['adressef_place_id'],
                            ];
                        } else {
                            $mappedData['invoice_address_infos'] = null;
                        }

                        //dd($mappedData);

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = Customer::where('id_customer', $item['id_customer'])->first();

                        // Créer une requête avec les données mappées
                        $request = new Request($mappedData);
                        
                        if ($existingSeller) {
                            // Valider les données
                            $validator = Validator::make($mappedData, (new UpdateCustomerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $storeCustomerRequest = new StoreCustomerRequest();
                            //$validator = Validator::make($mappedData, (new StoreCustomerRequest())->rules());
                            $validator = Validator::make($mappedData, $storeCustomerRequest->rules(), $storeCustomerRequest->messages());
                            
                
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Valider les données du customer
                            $customerData = $validator->validated();
                            $userData = $customerData['user_infos'] ?? null;
                            $comptaData = $customerData['compta_infos'] ?? null;
                            $statData = $customerData['stat_infos'] ?? null;
                            $invoiceAddressData = $customerData['invoice_address_infos'] ?? null;
                            
                            // Supprimer compta des données du customer
                            unset($customerData['user_infos']);
                            unset($customerData['compta_infos']);
                            unset($customerData['stat_infos']);
                            unset($customerData['invoice_address_infos']);

                            
                            // Créer les données du user avant de créer le customer
                            $storeUserRequest = new StoreUserRequest();

                            $userValidator = Validator::make($userData, $storeUserRequest->rules(), $storeUserRequest->messages());
                            
                            if ($userValidator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $userValidator->errors()->first());
                            }
                            
                            // Créer user
                            $validatedUserData = $userValidator->validate();
                            $user = User::create(array_merge($validatedUserData, ['id_user' => $item['id_customer']]));
                            
                            // Créer le customer
                            $customerData['id_user'] = $user->id_user;
                            $customer = Customer::create(array_merge($customerData, ['id_customer' => $item['id_customer']]));
                            
                            // Si des données invoice_address_infos sont présentes, valider avec StoreCustomerInvoiceAddressRequest
                            if ($invoiceAddressData) {
                                $invoiceAddressData['id_customer'] = $customer->id_customer;
                                $addressData = $invoiceAddressData['address_infos'] ?? null;

                                if ($addressData) {
                                    $storeCustomerAddressRequest = new StoreCustomerAddressRequest();

                                    $addressValidator = Validator::make($addressData, $storeCustomerAddressRequest->rules(), $storeCustomerAddressRequest->messages());
                                    
                                    if ($addressValidator->fails()) {
                                        throw new \Exception($erreurExceptionMessage . $addressValidator->errors()->first());
                                    }
                                    
                                    // Créer l'adresse client
                                    $validatedAddressData = $addressValidator->validate();
                                    $customerAddress = CustomerAddress::create($validatedAddressData);
                                    $invoiceAddressData['id_customer_address'] = $customerAddress->id_customer_address;
                                    
                                    // Associer l'adresse créée aux données de l'adresse de facturation
                                    $invoiceAddressData['id_customer_address'] = $customerAddress->id_customer_address;

                                    $storeInvoiceAddressRequest = new StoreInvoiceAddressRequest();

                                    $invoiceAddressValidator = Validator::make($invoiceAddressData, $storeInvoiceAddressRequest->rules(), $storeInvoiceAddressRequest->messages());
                                    
                                    if ($invoiceAddressValidator->fails()) {
                                        throw new \Exception($erreurExceptionMessage . $invoiceAddressValidator->errors()->first());
                                    }
                                    
                                    // Créer l'adresse de facturation
                                    
                                    unset($invoiceAddressData['address_infos']);
                                    $validatedInvoiceAddressData = $invoiceAddressValidator->validate();
                                    InvoiceAddress::create(array_merge($validatedInvoiceAddressData, ['id_customer_address' => $customerAddress->id_customer_address, 'id_invoice_address' => $item['id_customer']]) );
                                }
                                
                            }

                            // Si des données compta sont présentes, valider avec StoreCustomerComptaRequest
                            if ($comptaData) {
                                $comptaData['id_customer'] = $customer->id_customer;
                                
                                $storeCustomerComptaRequest = new StoreCustomerComptaRequest();

                                $comptaValidator = Validator::make($comptaData, $storeCustomerComptaRequest->rules(), $storeCustomerComptaRequest->messages());
                                
                                if ($comptaValidator->fails()) {
                                    throw new \Exception($erreurExceptionMessage . $comptaValidator->errors()->first());
                                }
                                
                                // Créer la comptabilité
                                $validatedComptaData = $comptaValidator->valid();
                                CustomerCompta::create(array_merge($validatedComptaData, ['id_customer_compta' => $customer->id_customer]));
                            }
                            
                            // Si des données stat sont présentes, valider avec StoreCustomerStatRequest
                            if ($statData) {
                                $statData['id_customer'] = $customer->id_customer;
                                $storeCustomerStatRequest = new StoreCustomerStatRequest();

                                $statValidator = Validator::make($statData, $storeCustomerStatRequest->rules(), $storeCustomerStatRequest->messages());
                                
                                if ($statValidator->fails()) {
                                    throw new \Exception($erreurExceptionMessage . $statValidator->errors()->first());
                                }

                                // Créer la statistique
                                $validatedStatData = $statValidator->valid();
                                CustomerStat::create(array_merge($validatedStatData, ['id_customer_stat' => $customer->id_customer]));
                            }
                            
                            dump("✅ $for Item créé: ID {$idItem}");
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

            if ($nextPageUrl && count($dataError) == 0 && intval($page) < 3) {
                return $this->importCustomerData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importCustomerData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }

    public function importShippingAddressData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'shipping_addresses';
        $dataError = $dataError;
        $object = null;
        $uri = "/services/customers/export_to_new_server/shipping_addresses?page=$page";
        $url = $baseUrl . $uri;

        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);

        //$response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [];
                        
                        $mappedData = [
                            'id_customer' => $item['id_customer'],
                            'is_default' => $item['default'],
                            'address_name' => $item['named'],
                            'has_difficult_access' => $item['difficult_access'],
                        ];
                        $mappedData['address_infos'] = [
                            'first_name' => $item['firstname'],
                            'last_name' => $item['lastname'],
                            'address' => $item['adress'],
                            'complement_address' => $item['complement_adress'],
                            'postal_code' => $item['pc'],
                            'city' => $item['ville'],
                            //'id_country' => CustomerCountry::where('name', $item['adressef_pays'])->orWhere('name_en', $item['adressef_pays'])->orWhere('name_de', $item['adressef_pays'])->value('id_customer_country'),
                            'id_country' => $item['id_pays'],
                            'phone' => $item['phone'] == '' ? null : $item['phone'],
                            'fax' => $item['fax'],
                            'longitude' => $item['lng'],
                            'latitude' => $item['lat'],
                            'place_id' => $item['place_id'],
                        ];

                        //dd($mappedData);

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = ShippingAddress::where('id_shipping_address', $item['id'])->first();
                        
                        if ($existingSeller) {
                            // Valider les données
                            /*$validator = Validator::make($mappedData, (new UpdateCustomerRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());*/
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $storeShippingAddressRequest = new StoreShippingAddressRequest();
                            //$validator = Validator::make($mappedData, (new StoreCustomerRequest())->rules());
                            $validator = Validator::make($mappedData, $storeShippingAddressRequest->rules(), $storeShippingAddressRequest->messages());
                            
                
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Valider les données du customer
                            $customerShippingData = $validator->validated();
                            $addressData = $customerShippingData['address_infos'] ?? null;
                            
                            // Supprimer compta des données du customer
                            unset($customerShippingData['address_infos']);
                            
                            // Si des données invoice_address_infos sont présentes, valider avec StoreCustomerInvoiceAddressRequest
                            
                            $storeCustomerAddressRequest = new StoreCustomerAddressRequest();

                            $addressValidator = Validator::make($addressData, $storeCustomerAddressRequest->rules(), $storeCustomerAddressRequest->messages());
                            
                            if ($addressValidator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $addressValidator->errors()->first());
                            }
                            
                            // Créer l'adresse client
                            $validatedAddressData = $addressValidator->validate();
                            $customerAddress = CustomerAddress::create($validatedAddressData);
                            
                            // Créer l'adresse de livraison
                            ShippingAddress::create(array_merge($customerShippingData, ['id_customer_address' => $customerAddress->id_customer_address, 'id_shipping_address' => $item['id']]) );
                            
                            
                            dump("✅ $for item créé: ID {$idItem}");
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

            if ($nextPageUrl && count($dataError) == 0 && intval($page) < 1) {
                return $this->importShippingAddressData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importShippingAddressData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }

    public function importCustomerContactData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'customer_contacts';
        $dataError = $dataError;
        $uri = "/services/customers/export_to_new_server/customer_contacts?page=$page";
        $url = $baseUrl . $uri;

        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);

        //$response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id_contact'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [];
                        
                        $mappedData = [
                            //'id_customer_contact' => $item['id_contact'],
                            'id_customer' => $item['id_customer'],
                            'first_name' => $item['firstname'],
                            'last_name' => $item['lastname'],
                            'phone_number' => $item['phone_number'],
                            'email_address' => $item['email'],
                            'id_contact_title' => $item['title'],
                            'phone_number_2' => $item['phone_number_2'],
                            'is_default' => $item['default'],
                            'id_contact_role' => $item['role'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = CustomerContact::where('id_customer_contact', $idItem)->first();
                        
                        if ($existingSeller) {
                            // Valider les données
                            /*$validator = Validator::make($mappedData, (new UpdateCustomerContactRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());*/
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $storeCustomerContactRequest = new StoreCustomerContactRequest();
                            $validator = Validator::make($mappedData, $storeCustomerContactRequest->rules(), $storeCustomerContactRequest->messages());
                            
                
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Valider les données du customer
                            $customerShippingData = $validator->validated();
                            
                            CustomerContact::create(array_merge($customerShippingData, ['id_customer_contact' => $idItem]) );
                            
                            
                            dump("✅ $for item créé: ID {$idItem}");
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

            if ($nextPageUrl && count($dataError) == 0 && intval($page) < 2) {
                return $this->importCustomerContactData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importCustomerContactData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }

    public function importCustomerContactProfileData(string $baseUrl, int $page = 1, int $dataImported = 0, array $dataError = [])
    {
        $for = 'customer_contact_profile';
        $dataError = $dataError;
        $uri = "/services/customers/export_to_new_server/contact_profiles?page=$page";
        $url = $baseUrl . $uri;

        // CONFIGURATION DU TIMEOUT - AJOUTEZ CES LIGNES
        $httpClient = Http::timeout(120)  // 2 minutes pour la requête complète
                        ->connectTimeout(30)  // 30 secondes pour la connexion
                        ->retry(3, 1000);  // 3 tentatives avec délai
        
        $response = $httpClient->get($url);

        //$response = Http::get($url);
        
        if ($response->successful()) {

            $responseJson = $response->json();
            $nextPageUrl = $responseJson['data']['next_page_url'];
            $lastPage = intval($responseJson['data']['last_page']);
            $to = intval($responseJson['data']['to']);
            $data = $responseJson['data']['data'];
           
            if($data) {
                foreach($data as $k => $item) {
                    $idItem = $item['id_contact_profile'] ?? 'unknown';
                    $erreurExceptionMessage = "Erreur lors de l'import à la page $page pour $for ID {$idItem}: ";
                    try {
                        // Mapper les données de l'ancien serveur vers le nouveau format
                        $mappedData = [];
                        
                        $mappedData = [
                            //'id_customer_contact' => $item['id_contact'],
                            'id_customer' => $item['id_customer'],
                            'first_name' => $item['firstname'],
                            'last_name' => $item['lastname'],
                            'phone_number' => $item['phone_number'],
                            'email_address' => $item['email'],
                            'id_contact_title' => $item['title'],
                            'phone_number_2' => $item['phone_number_2'],
                            'is_default' => $item['default'],
                            'id_contact_role' => $item['role'],
                        ];

                        // Vérifier si le vendeur existe déjà dans la base de données
                        $existingSeller = CustomerContact::where('id_customer_contact', $idItem)->first();
                        
                        if ($existingSeller) {
                            // Valider les données
                            /*$validator = Validator::make($mappedData, (new UpdateCustomerContactRequest())->rules());
                            
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Mettre à jour avec les données validées
                            $existingSeller->update($validator->validated());*/
                            
                            dump("🔄 Item mis à jour: ID {$idItem}");
                        } else {
                            // Valider les données
                            $storeCustomerContactRequest = new StoreCustomerContactRequest();
                            $validator = Validator::make($mappedData, $storeCustomerContactRequest->rules(), $storeCustomerContactRequest->messages());
                            
                
                            if ($validator->fails()) {
                                throw new \Exception($erreurExceptionMessage . $validator->errors()->first());
                            }
                            
                            // Valider les données du customer
                            $customerShippingData = $validator->validated();
                            
                            CustomerContact::create(array_merge($customerShippingData, ['id_customer_contact' => $idItem]) );
                            
                            
                            dump("✅ $for item créé: ID {$idItem}");
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

            if ($nextPageUrl && count($dataError) == 0 && intval($page) < 2) {
                return $this->importCustomerContactData($baseUrl, intval($page) + 1, $dataImported, $dataError);
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
                return $this->importCustomerContactData($baseUrl,intval($page), $dataImported, $dataError);
            }
            throw new \Exception("Erreur HTTP " . $response->status() . " lors de la récupération des données depuis $url");
        }
    }
}