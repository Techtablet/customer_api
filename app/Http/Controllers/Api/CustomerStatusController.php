<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerStatus;
use App\Http\Requests\CustomerStatus\StoreCustomerStatusRequest;
use App\Http\Requests\CustomerStatus\UpdateCustomerStatusRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="CustomerStatus",
 *     description="API pour gérer les statuts clients"
 * )
 */
class CustomerStatusController extends Controller
{
    /**
     * Liste tous les statuts clients
     *
     * @OA\Get(
     *     path="/api/customer-statuses",
     *     tags={"CustomerStatus"},
     *     summary="Liste tous les statuts clients",
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussite",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Opération réussite"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerStatus")
     *             )
     *         )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $statuses = CustomerStatus::all();
        return response()->json([
            'success' => true,
            'message' => 'Opération réussite',
            'data' => $statuses
        ]);
    }

    /**
     * Crée un nouveau statut client
     *
     * @OA\Post(
     *     path="/api/customer-statuses",
     *     tags={"CustomerStatus"},
     *     summary="Créer un statut client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CustomerStatus")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Statut créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Statut créé avec succès"),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStatus")
     *         )
     *     )
     * )
     *
     * @param StoreCustomerStatusRequest $request
     * @return JsonResponse
     */
    public function store(StoreCustomerStatusRequest $request): JsonResponse
    {
        $status = CustomerStatus::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Statut créé avec succès',
            'data' => $status
        ], 201);
    }

    /**
     * Affiche un statut client par ID
     *
     * @OA\Get(
     *     path="/api/customer-statuses/{id}",
     *     tags={"CustomerStatus"},
     *     summary="Afficher un statut client par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut client",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussite",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Opération réussite"),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStatus")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Statut non trouvé")
     * )
     *
     * @param CustomerStatus $customerStatus
     * @return JsonResponse
     */
    public function show(CustomerStatus $customerStatus): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Opération réussite',
            'data' => $customerStatus
        ]);
    }

    /**
     * Met à jour un statut client
     *
     * @OA\Put(
     *     path="/api/customer-statuses/{id}",
     *     tags={"CustomerStatus"},
     *     summary="Mettre à jour un statut client",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut client",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CustomerStatus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut mis à jour avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Statut mis à jour avec succès"),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStatus")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Statut non trouvé")
     * )
     *
     * @param UpdateCustomerStatusRequest $request
     * @param CustomerStatus $customerStatus
     * @return JsonResponse
     */
    public function update(UpdateCustomerStatusRequest $request, CustomerStatus $customerStatus): JsonResponse
    {
        $customerStatus->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'data' => $customerStatus
        ]);
    }

    /**
     * Supprime un statut client
     *
     * @OA\Delete(
     *     path="/api/customer-statuses/{id}",
     *     tags={"CustomerStatus"},
     *     summary="Supprimer un statut client",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut client",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut supprimé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Statut supprimé avec succès")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Statut non trouvé")
     * )
     *
     * @param CustomerStatus $customerStatus
     * @return JsonResponse
     */
    public function destroy(CustomerStatus $customerStatus): JsonResponse
    {
        $customerStatus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Statut supprimé avec succès'
        ]);
    }
}
