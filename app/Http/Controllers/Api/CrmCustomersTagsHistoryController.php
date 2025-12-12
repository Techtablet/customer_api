<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmCustomersTagsHistoryRequest\StoreCrmCustomersTagsHistoryRequest;
use App\Http\Requests\CrmCustomersTagsHistoryRequest\UpdateCrmCustomersTagsHistoryRequest;
use App\Models\CrmCustomersTagsHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CrmCustomersTagsHistory",
 *     description="Opérations CRUD pour l'historique des tags CRM des clients"
 * )
 */
class CrmCustomersTagsHistoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history",
     *     summary="Liste tout l'historique des tags CRM",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Response(
     *         response=200,
     *         description="Historique récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTagsHistory")
     *             ),
     *             @OA\Property(property="message", type="string", example="Historique des tags CRM récupéré avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $history = CrmCustomersTagsHistory::with(['crmTag', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Historique des tags CRM récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history/{id}",
     *     summary="Affiche les détails d'une entrée d'historique spécifique",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'entrée d'historique",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrée d'historique récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTagsHistory"),
     *             @OA\Property(property="message", type="string", example="Entrée d'historique récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrée d'historique non trouvée"
     *     )
     * )
     */
    public function show(CrmCustomersTagsHistory $crmCustomersTagsHistory): JsonResponse
    {
        $crmCustomersTagsHistory->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTagsHistory,
            'message' => 'Entrée d\'historique récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history/customer/{customerId}",
     *     summary="Récupère l'historique des tags d'un client spécifique",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historique du client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTagsHistory")
     *             ),
     *             @OA\Property(property="message", type="string", example="Historique des tags du client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun historique trouvé pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $history = CrmCustomersTagsHistory::forCustomer($customerId)
            ->with(['crmTag', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($history->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun historique trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Historique des tags du client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history/tag/{tagId}",
     *     summary="Récupère l'historique des clients ayant un tag spécifique",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="tagId",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historique du tag récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTagsHistory")
     *             ),
     *             @OA\Property(property="message", type="string", example="Historique du tag récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun historique trouvé pour ce tag"
     *     )
     * )
     */
    public function showByTag($tagId): JsonResponse
    {
        $history = CrmCustomersTagsHistory::forTag($tagId)
            ->with(['crmTag', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($history->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun historique trouvé pour ce tag.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Historique du tag récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history/recent/{days}",
     *     summary="Récupère l'historique récent",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="days",
     *         in="path",
     *         required=true,
     *         description="Nombre de jours",
     *         @OA\Schema(type="integer", default=30)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historique récent récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTagsHistory")
     *             ),
     *             @OA\Property(property="message", type="string", example="Historique récent récupéré avec succès.")
     *         )
     *     )
     * )
     */
    public function showRecent($days = 30): JsonResponse
    {
        $history = CrmCustomersTagsHistory::recent($days)
            ->with(['crmTag', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Historique récent récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags-history/period/{startDate}/{endDate}",
     *     summary="Récupère l'historique dans une période donnée",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="path",
     *         required=true,
     *         description="Date de début (format: YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2024-01-01")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="path",
     *         required=true,
     *         description="Date de fin (format: YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2024-12-31")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historique de la période récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTagsHistory")
     *             ),
     *             @OA\Property(property="message", type="string", example="Historique de la période récupéré avec succès.")
     *         )
     *     )
     * )
     */
    public function showByPeriod($startDate, $endDate): JsonResponse
    {
        $history = CrmCustomersTagsHistory::betweenDates($startDate, $endDate)
            ->with(['crmTag', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history,
            'message' => 'Historique de la période récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/crm-customers-tags-history",
     *     summary="Ajoute une nouvelle entrée à l'historique",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCrmCustomersTagsHistoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Entrée d'historique créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTagsHistory"),
     *             @OA\Property(property="message", type="string", example="Entrée d'historique créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCrmCustomersTagsHistoryRequest $request): JsonResponse
    {
        $historyEntry = CrmCustomersTagsHistory::create($request->validated());

        $historyEntry->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $historyEntry,
            'message' => 'Entrée d\'historique créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/crm-customers-tags-history/{id}",
     *     summary="Met à jour une entrée d'historique existante",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'entrée d'historique à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCrmCustomersTagsHistoryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrée d'historique mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTagsHistory"),
     *             @OA\Property(property="message", type="string", example="Entrée d'historique mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrée d'historique non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCrmCustomersTagsHistoryRequest $request, CrmCustomersTagsHistory $crmCustomersTagsHistory): JsonResponse
    {
        $crmCustomersTagsHistory->update($request->validated());

        $crmCustomersTagsHistory->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTagsHistory,
            'message' => 'Entrée d\'historique mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-customers-tags-history/{id}",
     *     summary="Supprime une entrée d'historique",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'entrée d'historique à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrée d'historique supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Entrée d'historique supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrée d'historique non trouvée"
     *     )
     * )
     */
    public function destroy(CrmCustomersTagsHistory $crmCustomersTagsHistory): JsonResponse
    {
        $crmCustomersTagsHistory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Entrée d\'historique supprimée avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-customers-tags-history/customer/{customerId}",
     *     summary="Supprime tout l'historique d'un client",
     *     tags={"CrmCustomersTagsHistory"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historique du client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="deleted_count", type="integer", example=5),
     *             @OA\Property(property="message", type="string", example="Historique du client supprimé avec succès.")
     *         )
     *     )
     * )
     */
    public function destroyByCustomer($customerId): JsonResponse
    {
        $deletedCount = CrmCustomersTagsHistory::where('id_customer', $customerId)->delete();

        return response()->json([
            'success' => true,
            'deleted_count' => $deletedCount,
            'message' => 'Historique du client supprimé avec succès.',
        ]);
    }
}