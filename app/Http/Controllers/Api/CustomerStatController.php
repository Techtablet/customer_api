<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStatRequest\StoreCustomerStatRequest;
use App\Http\Requests\CustomerStatRequest\UpdateCustomerStatRequest;
use App\Models\CustomerStat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerStats",
 *     description="Opérations CRUD pour les statistiques clients"
 * )
 */
class CustomerStatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-stats",
     *     summary="Liste toutes les statistiques clients",
     *     tags={"CustomerStats"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des statistiques clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerStat")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des statistiques clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerStats = CustomerStat::with('customer')->get();

        return response()->json([
            'success' => true,
            'data' => $customerStats,
            'message' => 'Liste des statistiques clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-stats/{id}",
     *     summary="Affiche les détails des statistiques d'un client spécifique",
     *     tags={"CustomerStats"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID des statistiques client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statistiques client récupérées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStat"),
     *             @OA\Property(property="message", type="string", example="Statistiques client récupérées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statistiques client non trouvées"
     *     )
     * )
     */
    public function show(CustomerStat $customerStat): JsonResponse
    {
        $customerStat->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerStat,
            'message' => 'Statistiques client récupérées avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-stats",
     *     summary="Crée de nouvelles statistiques client",
     *     tags={"CustomerStats"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerStatRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Statistiques client créées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStat"),
     *             @OA\Property(property="message", type="string", example="Statistiques client créées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerStatRequest $request): JsonResponse
    {
        $customerStat = CustomerStat::create($request->validated());
        $customerStat->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerStat,
            'message' => 'Statistiques client créées avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-stats/{id}",
     *     summary="Met à jour les statistiques d'un client existant",
     *     tags={"CustomerStats"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID des statistiques client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerStatRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statistiques client mises à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerStat"),
     *             @OA\Property(property="message", type="string", example="Statistiques client mises à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statistiques client non trouvées"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerStatRequest $request, CustomerStat $customerStat): JsonResponse
    {
        $customerStat->update($request->validated());
        $customerStat->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerStat,
            'message' => 'Statistiques client mises à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-stats/{id}",
     *     summary="Supprime les statistiques d'un client",
     *     tags={"CustomerStats"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID des statistiques client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statistiques client supprimées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Statistiques client supprimées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statistiques client non trouvées"
     *     )
     * )
     */
    public function destroy(CustomerStat $customerStat): JsonResponse
    {
        $customerStat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Statistiques client supprimées avec succès.',
        ]);
    }
}