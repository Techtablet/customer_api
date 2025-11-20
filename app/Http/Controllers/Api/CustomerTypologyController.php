<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerTypologyRequest\StoreCustomerTypologyRequest;
use App\Http\Requests\CustomerTypologyRequest\UpdateCustomerTypologyRequest;
use App\Models\CustomerTypology;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerTypologies",
 *     description="Opérations CRUD pour les typologies clients"
 * )
 */
class CustomerTypologyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-typologies",
     *     summary="Liste toutes les typologies clients",
     *     tags={"CustomerTypologies"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des typologies clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerTypology")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des typologies clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerTypologies = CustomerTypology::all();

        return response()->json([
            'success' => true,
            'data' => $customerTypologies,
            'message' => 'Liste des typologies clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-typologies/{id}",
     *     summary="Affiche les détails d'une typologie client spécifique",
     *     tags={"CustomerTypologies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la typologie client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Typologie client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerTypology"),
     *             @OA\Property(property="message", type="string", example="Typologie client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Typologie client non trouvée"
     *     )
     * )
     */
    public function show(CustomerTypology $customerTypology): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerTypology,
            'message' => 'Typologie client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-typologies",
     *     summary="Crée une nouvelle typologie client",
     *     tags={"CustomerTypologies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerTypologyRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Typologie client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerTypology"),
     *             @OA\Property(property="message", type="string", example="Typologie client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerTypologyRequest $request): JsonResponse
    {
        $customerTypology = CustomerTypology::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerTypology,
            'message' => 'Typologie client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-typologies/{id}",
     *     summary="Met à jour une typologie client existante",
     *     tags={"CustomerTypologies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la typologie client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerTypologyRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Typologie client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerTypology"),
     *             @OA\Property(property="message", type="string", example="Typologie client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Typologie client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerTypologyRequest $request, CustomerTypology $customerTypology): JsonResponse
    {
        $customerTypology->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerTypology,
            'message' => 'Typologie client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-typologies/{id}",
     *     summary="Supprime une typologie client",
     *     tags={"CustomerTypologies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la typologie client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Typologie client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Typologie client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Typologie client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerTypology $customerTypology): JsonResponse
    {
        $customerTypology->delete();

        return response()->json([
            'success' => true,
            'message' => 'Typologie client supprimée avec succès.',
        ]);
    }
}