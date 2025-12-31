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
        
        $customers = Customer::with([
            'franchise',
            'seller',
            'lang',
            'location',
            'typologie',
            'canvassing_step',
            'store_group',
            'refusal_reason'
        ])->paginate($perPage);

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
    public function show(Customer $customer): JsonResponse
    {
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
            $userData = $customerData['user_infos'] ?? [];
            $comptaData = $customerData['compta_infos'] ?? [];
            $statData = $customerData['stat_infos'] ?? [];
            $invoiceAddressData = $customerData['invoice_address_infos'];
            
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
            $comptaData['id_customer'] = $customer->id_customer;
            $statData['id_customer'] = $customer->id_customer;
            $invoiceAddressData['id_customer'] = $customer->id_customer;

            // Si des données invoice_address_infos sont présentes, valider avec StoreCustomerInvoiceAddressRequest
            if ($invoiceAddressData) {
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