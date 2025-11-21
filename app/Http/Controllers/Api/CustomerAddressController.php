<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddressRequest\StoreCustomerAddressRequest;
use App\Http\Requests\CustomerAddressRequest\UpdateCustomerAddressRequest;
use App\Models\CustomerAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerAddresses",
 *     description="Opérations CRUD pour les adresses clients"
 * )
 */
class CustomerAddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-addresses",
     *     summary="Liste toutes les adresses clients",
     *     tags={"CustomerAddresses"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des adresses clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerAddress")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des adresses clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerAddresses = CustomerAddress::with('country')->get();

        return response()->json([
            'success' => true,
            'data' => $customerAddresses,
            'message' => 'Liste des adresses clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-addresses/{id}",
     *     summary="Affiche les détails d'une adresse client spécifique",
     *     tags={"CustomerAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse client non trouvée"
     *     )
     * )
     */
    public function show(CustomerAddress $customerAddress): JsonResponse
    {
        $customerAddress->load('country');

        return response()->json([
            'success' => true,
            'data' => $customerAddress,
            'message' => 'Adresse client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-addresses",
     *     summary="Crée une nouvelle adresse client",
     *     tags={"CustomerAddresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Adresse client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerAddressRequest $request): JsonResponse
    {
        $customerAddress = CustomerAddress::create($request->validated());
        $customerAddress->load('country');

        return response()->json([
            'success' => true,
            'data' => $customerAddress,
            'message' => 'Adresse client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-addresses/{id}",
     *     summary="Met à jour une adresse client existante",
     *     tags={"CustomerAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerAddressRequest $request, CustomerAddress $customerAddress): JsonResponse
    {
        $customerAddress->update($request->validated());
        $customerAddress->load('country');

        return response()->json([
            'success' => true,
            'data' => $customerAddress,
            'message' => 'Adresse client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-addresses/{id}",
     *     summary="Supprime une adresse client",
     *     tags={"CustomerAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Adresse client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerAddress $customerAddress): JsonResponse
    {
        $customerAddress->delete();

        return response()->json([
            'success' => true,
            'message' => 'Adresse client supprimée avec succès.',
        ]);
    }
}