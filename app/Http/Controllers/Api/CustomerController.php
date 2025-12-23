<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest\StoreCustomerRequest;
use App\Http\Requests\CustomerRequest\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $customer = Customer::create($request->validated());
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
            'message' => 'Client créé avec succès.',
        ], Response::HTTP_CREATED);
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