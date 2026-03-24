<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

use App\Http\Requests\InvoiceAddressRequest\StoreInvoiceAddressRequest;
use App\Http\Requests\InvoiceAddressRequest\UpdateInvoiceAddressRequest;
use App\Models\InvoiceAddress;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\HttpCache\Store;

use App\Http\Services\CustomerService;

/**
 * @OA\Tag(
 *     name="Customers",
 *     description="Opérations CRUD pour les clients"
 * )
 */
class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customers",
     *     summary="Liste tous les clients avec pagination",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Numéro de la page",
     *         required=false,
     *         @OA\Schema(type="integer", default=1, minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Nombre d'éléments par page (max: 100)",
     *         required=false,
     *         @OA\Schema(type="integer", default=100, minimum=1, maximum=100)
     *     ),
     *     @OA\Parameter(
     *         name="id_customer",
     *         in="query",
     *         description="ID du client",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with_user",
     *         in="query",
     *         description="Inclure les utilisateurs associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_franchise",
     *         in="query",
     *         description="Inclure les franchises associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_seller",
     *         in="query",
     *         description="Inclure les vendeurs associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_lang",
     *         in="query",
     *         description="Inclure les langues associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_location",
     *         in="query",
     *         description="Inclure les lieux associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_typology",
     *         in="query",
     *         description="Inclure les typologies associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_canvassing_step",
     *         in="query",
     *         description="Inclure les étapes de canvassing associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_store_group",
     *         in="query",
     *         description="Inclure les groupes de magasins associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_refusal_reason",
     *         in="query",
     *         description="Inclure les raisons de refus associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_invoice_address",
     *         in="query",
     *         description="Inclure les adresses de facturation associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_shipping_addresses",
     *         in="query",
     *         description="Inclure les adresses de livraison associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_shipping_addresse_default",
     *         in="query",
     *         description="Inclure l'adresses de livraison par defaut associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_customer_compta",
     *         in="query",
     *         description="Inclure les données comptables du client",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_customer_contacts",
     *         in="query",
     *         description="Inclure les contacts du client",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_customer_contact_default",
     *         in="query",
     *         description="Inclure le contact du client par défaut",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="format_data",
     *         in="query",
     *         description="Formater les données pour le gestionnaire de clients",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste paginée des clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Customer")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 ref="#/components/schemas/PaginationMeta"
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 100), 100);
        
        $customers = Customer::query();

        if ($request->has('id_customer')) {
            $customers->where('id_customer', $request->input('id_customer'));
        }
        if ($request->has('with_user') && $request->boolean('with_user')) {
            $customers->with('user');
        }
        if ($request->has('with_franchise') && $request->boolean('with_franchise')) {
            $customers->with('franchise');
        }
        if ($request->has('with_seller') && $request->boolean('with_seller')) {
            $customers->with('seller');
        }
        if ($request->has('with_lang') && $request->boolean('with_lang')) {
            $customers->with('lang');
        }
        if ($request->has('with_location') && $request->boolean('with_location')) {
            $customers->with('location');
        }
        if ($request->has('with_typology') && $request->boolean('with_typology')) {
            $customers->with('typology');
        }
        if ($request->has('with_canvassing_step') && $request->boolean('with_canvassing_step')) {
            $customers->with('canvassing_step');
        }
        if ($request->has('with_store_group') && $request->boolean('with_store_group')) {
            $customers->with('store_group');
        }
        if ($request->has('with_refusal_reason') && $request->boolean('with_refusal_reason')) {
            $customers->with('refusal_reason');
        }
        if ($request->has('with_invoice_address') && $request->boolean('with_invoice_address')) {
            $customers->with('invoice_address.customerAddress');
        }
        if ($request->has('with_shipping_addresses') && $request->boolean('with_shipping_addresses')) {
            $customers->with('shipping_addresses.customerAddress');
        }
        if ($request->has('with_shipping_addresse_default') && $request->boolean('with_shipping_addresse_default')) {
            $customers->with('shipping_addresse_default.customerAddress');
        }
        if ($request->has('with_customer_compta') && $request->boolean('with_customer_compta')) {
            $customers->with('customer_compta');
        }
        if ($request->has('with_customer_contacts') && $request->boolean('with_customer_contacts')) {
            $customers->with('customer_contacts.contactTitle', 'customer_contacts.contactRole');
        }
        if ($request->has('with_customer_contact_default') && $request->boolean('with_customer_contact_default')) {
            $customers->with('customer_contact_default.contactTitle', 'customer_contact_default.contactRole');
        }

        $customers = $customers->paginate($perPage);

        $data = $customers->items();
        if ($request->has('format_data') && $request->boolean('format_data')) {
            $dataFormated = [];
            foreach ($customers->items() as $customer) {
                $dataFormated[] = CustomerService::format_data_for_customer_manager($customer->toArray());
            }
            $data = $dataFormated;
        }

        return response()->json([
            'success' => true,
            'data' => $customers->items(),
            'pagination' => [
                'current_page' => $customers->currentPage(),
                'per_page' => $customers->perPage(),
                'total' => $customers->total(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
            ],
            'message' => 'Liste des clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customers/{id}",
     *     summary="Affiche les détails d'un client spécifique",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Nombre d'éléments par page (max: 100)",
     *         required=false,
     *         @OA\Schema(type="integer", default=100, minimum=1, maximum=100)
     *     ),
     *     @OA\Parameter(
     *         name="with_franchise",
     *         in="query",
     *         description="Inclure les franchises associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_seller",
     *         in="query",
     *         description="Inclure les vendeurs associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_lang",
     *         in="query",
     *         description="Inclure les langues associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_location",
     *         in="query",
     *         description="Inclure les lieux associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_typology",
     *         in="query",
     *         description="Inclure les typologies associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_canvassing_step",
     *         in="query",
     *         description="Inclure les étapes de canvassing associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_store_group",
     *         in="query",
     *         description="Inclure les groupes de magasins associés",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="with_refusal_reason",
     *         in="query",
     *         description="Inclure les raisons de refus associées",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer"),
     *             @OA\Property(property="message", type="string", example="Client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     )
     * )
     */
    public function show(Customer $customer, Request $request): JsonResponse
    {
        if ($request->has('with_franchise') && $request->boolean('with_franchise')) {
            $customer->load('franchise');
        }
        if ($request->has('with_seller') && $request->boolean('with_seller')) {
            $customer->load('seller');
        }
        if ($request->has('with_lang') && $request->boolean('with_lang')) {
            $customer->load('lang');
        }
        if ($request->has('with_location') && $request->boolean('with_location')) {
            $customer->load('location');
        }
        if ($request->has('with_typology') && $request->boolean('with_typology')) {
            $customer->load('typology');
        }
        if ($request->has('with_canvassing_step') && $request->boolean('with_canvassing_step')) {
            $customer->load('canvassing_step');
        }
        if ($request->has('with_store_group') && $request->boolean('with_store_group')) {
            $customer->load('store_group');
        }
        if ($request->has('with_refusal_reason') && $request->boolean('with_refusal_reason')) {
            $customer->load('refusal_reason');
        }
        /*$customer->load(['franchise','seller',]);*/

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customers",
     *     summary="Crée un nouveau client",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer"),
     *             @OA\Property(property="message", type="string", example="Client créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            // Valider les données du customer
            $customerData = $request->validated();
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
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'errors' => $userValidator->errors(),
                    'message' => 'Validation des données de comptabilité échouée.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            
            // Créer user
            $validatedUserData = $userValidator->validated();
            $user = User::create($validatedUserData);

            // Créer le customer
            $customerData['id_user'] = $user->id_user;
            $customer = Customer::create($customerData);

            // Si des données invoice_address_infos sont présentes, valider avec StoreCustomerInvoiceAddressRequest
            if ($invoiceAddressData) {
                
                $invoiceAddressData['id_customer'] = $customer->id_customer;
                $addressData = $invoiceAddressData['address_infos'] ?? null;

                if ($addressData) {
                    $storeCustomerAddressRequest = new StoreCustomerAddressRequest();

                    $addressValidator = Validator::make($addressData, $storeCustomerAddressRequest->rules(), $storeCustomerAddressRequest->messages());
                    
                    if ($addressValidator->fails()) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'errors' => $addressValidator->errors(),
                            'message' => 'Validation des données de l\'adresse échouée.',
                        ], Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    
                    // Créer l'adresse client
                    $validatedAddressData = $addressValidator->validated();
                    $customerAddress = CustomerAddress::create($validatedAddressData);
                    $invoiceAddressData['id_customer_address'] = $customerAddress->id_customer_address;
                    
                    // Associer l'adresse créée aux données de l'adresse de facturation
                    $invoiceAddressData['id_customer_address'] = $customerAddress->id_customer_address;

                    $storeInvoiceAddressRequest = new StoreInvoiceAddressRequest();

                    $invoiceAddressValidator = Validator::make($invoiceAddressData, $storeInvoiceAddressRequest->rules(), $storeInvoiceAddressRequest->messages());
                    
                    if ($invoiceAddressValidator->fails()) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'errors' => $invoiceAddressValidator->errors(),
                            'message' => 'Validation des données de l\'adresse de facturation échouée.',
                        ], Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    
                    // Créer l'adresse de facturation
                    
                    unset($invoiceAddressData['address_infos']);
                    $validatedInvoiceAddressData = $invoiceAddressValidator->validated();
                    InvoiceAddress::create(array_merge($validatedInvoiceAddressData, ['id_customer_address' => $customerAddress->id_customer_address]));
                }
                
            }
            
            // Si des données compta sont présentes, valider avec StoreCustomerComptaRequest
            if ($comptaData) {
                $comptaData['id_customer'] = $customer->id_customer;
                
                $storeCustomerComptaRequest = new StoreCustomerComptaRequest();

                $comptaValidator = Validator::make($comptaData, $storeCustomerComptaRequest->rules(), $storeCustomerComptaRequest->messages());
                
                if ($comptaValidator->fails()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'errors' => $comptaValidator->errors(),
                        'message' => 'Validation des données de comptabilité échouée.',
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                
                // Créer la comptabilité
                $validatedComptaData = $comptaValidator->validated();
                CustomerCompta::create($validatedComptaData);
            }

            // Si des données stat sont présentes, valider avec StoreCustomerStatRequest
            if ($statData) {
                $statData['id_customer'] = $customer->id_customer;  
                
                $storeCustomerStatRequest = new StoreCustomerStatRequest();

                $statValidator = Validator::make($statData, $storeCustomerStatRequest->rules(), $storeCustomerStatRequest->messages());
                
                if ($statValidator->fails()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'errors' => $statValidator->errors(),
                        'message' => 'Validation des données de statistique échouée.',
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                // Créer la statistique
                $validatedStatData = $statValidator->validated();
                CustomerStat::create($validatedStatData);
            }
            
            // Charger les relations
            $customer->load(['franchise', 'seller', 'lang', 'location', 'typologie', 'canvassing_step', 'store_group', 'refusal_reason']);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $customer,
                'message' => 'Client créé avec succès' . ($comptaData ? ' avec ses informations de comptabilité.' : '.'),
            ], Response::HTTP_CREATED);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du client: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du client.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/customers/{id}",
     *     summary="Met à jour un client existant",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer"),
     *             @OA\Property(property="message", type="string", example="Client mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());
        $customer->load([
            'franchise',
            'seller',
            'lang',
            'location',
            'typologie',
            'canvassing_step',
            'store_group',
            'refusal_reason'
        ]);

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Client mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customers/{id}",
     *     summary="Supprime un client",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Client supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     )
     * )
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client supprimé avec succès.',
        ]);
    }
}