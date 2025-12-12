<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmCallRequest\StoreCrmCallRequest;
use App\Http\Requests\CrmCallRequest\UpdateCrmCallRequest;
use App\Models\CrmCall;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CrmCalls",
 *     description="Opérations CRUD pour les appels CRM"
 * )
 */
class CrmCallController extends Controller
{
    /**
     * @OA\Get(
     *     path="/crm-calls",
     *     summary="Liste tous les appels CRM",
     *     tags={"CrmCalls"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des appels CRM récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCall")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des appels CRM récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $crmCalls = CrmCall::with(['customer', 'techtabletSeller', 'crmCallsStatus'])
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $crmCalls,
            'message' => 'Liste des appels CRM récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls/{id}",
     *     summary="Affiche les détails d'un appel CRM spécifique",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'appel CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appel CRM récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCall"),
     *             @OA\Property(property="message", type="string", example="Appel CRM récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appel CRM non trouvé"
     *     )
     * )
     */
    public function show(CrmCall $crmCall): JsonResponse
    {
        $crmCall->load(['customer', 'techtabletSeller', 'crmCallsStatus']);

        return response()->json([
            'success' => true,
            'data' => $crmCall,
            'message' => 'Appel CRM récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls/customer/{customerId}",
     *     summary="Récupère les appels d'un client spécifique",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appels du client récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCall")
     *             ),
     *             @OA\Property(property="message", type="string", example="Appels du client récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun appel trouvé pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $crmCalls = CrmCall::forCustomer($customerId)
            ->with(['customer', 'techtabletSeller', 'crmCallsStatus'])
            ->orderBy('date', 'desc')
            ->get();

        if ($crmCalls->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun appel trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $crmCalls,
            'message' => 'Appels du client récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls/seller/{sellerId}",
     *     summary="Récupère les appels d'un commercial spécifique",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="sellerId",
     *         in="path",
     *         required=true,
     *         description="ID du commercial",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appels du commercial récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCall")
     *             ),
     *             @OA\Property(property="message", type="string", example="Appels du commercial récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun appel trouvé pour ce commercial"
     *     )
     * )
     */
    public function showBySeller($sellerId): JsonResponse
    {
        $crmCalls = CrmCall::forSeller($sellerId)
            ->with(['customer', 'techtabletSeller', 'crmCallsStatus'])
            ->orderBy('date', 'desc')
            ->get();

        if ($crmCalls->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun appel trouvé pour ce commercial.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $crmCalls,
            'message' => 'Appels du commercial récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls/status/{statusId}",
     *     summary="Récupère les appels avec un statut spécifique",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="statusId",
     *         in="path",
     *         required=true,
     *         description="ID du statut",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appels avec ce statut récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCall")
     *             ),
     *             @OA\Property(property="message", type="string", example="Appels avec ce statut récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun appel trouvé avec ce statut"
     *     )
     * )
     */
    public function showByStatus($statusId): JsonResponse
    {
        $crmCalls = CrmCall::withStatus($statusId)
            ->with(['customer', 'techtabletSeller', 'crmCallsStatus'])
            ->orderBy('date', 'desc')
            ->get();

        if ($crmCalls->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun appel trouvé avec ce statut.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $crmCalls,
            'message' => 'Appels avec ce statut récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls/recent/{days}",
     *     summary="Récupère les appels récents",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="days",
     *         in="path",
     *         required=true,
     *         description="Nombre de jours",
     *         @OA\Schema(type="integer", default=30)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appels récents récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCall")
     *             ),
     *             @OA\Property(property="message", type="string", example="Appels récents récupérés avec succès.")
     *         )
     *     )
     * )
     */
    public function showRecent($days = 30): JsonResponse
    {
        $crmCalls = CrmCall::recent($days)
            ->with(['customer', 'techtabletSeller', 'crmCallsStatus'])
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $crmCalls,
            'message' => 'Appels récents récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/crm-calls",
     *     summary="Crée un nouvel appel CRM",
     *     tags={"CrmCalls"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCrmCallRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appel CRM créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCall"),
     *             @OA\Property(property="message", type="string", example="Appel CRM créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCrmCallRequest $request): JsonResponse
    {
        $crmCall = CrmCall::create($request->validated());

        $crmCall->load(['customer', 'techtabletSeller', 'crmCallsStatus']);

        return response()->json([
            'success' => true,
            'data' => $crmCall,
            'message' => 'Appel CRM créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/crm-calls/{id}",
     *     summary="Met à jour un appel CRM existant",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'appel CRM à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCrmCallRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appel CRM mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCall"),
     *             @OA\Property(property="message", type="string", example="Appel CRM mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appel CRM non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCrmCallRequest $request, CrmCall $crmCall): JsonResponse
    {
        $crmCall->update($request->validated());

        $crmCall->load(['customer', 'techtabletSeller', 'crmCallsStatus']);

        return response()->json([
            'success' => true,
            'data' => $crmCall,
            'message' => 'Appel CRM mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-calls/{id}",
     *     summary="Supprime un appel CRM",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'appel CRM à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appel CRM supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Appel CRM supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appel CRM non trouvé"
     *     )
     * )
     */
    public function destroy(CrmCall $crmCall): JsonResponse
    {
        $crmCall->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appel CRM supprimé avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/crm-calls/{id}/mark-shipping-done",
     *     summary="Marque l'expédition comme faite pour un appel",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'appel CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expédition marquée comme faite avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCall"),
     *             @OA\Property(property="message", type="string", example="Expédition marquée comme faite avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appel CRM non trouvé"
     *     )
     * )
     */
    public function markShippingDone(CrmCall $crmCall): JsonResponse
    {
        $crmCall->update(['shipping_done' => 1]);

        $crmCall->load(['customer', 'techtabletSeller', 'crmCallsStatus']);

        return response()->json([
            'success' => true,
            'data' => $crmCall,
            'message' => 'Expédition marquée comme faite avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/crm-calls/{id}/mark-shipping-undone",
     *     summary="Marque l'expédition comme non faite pour un appel",
     *     tags={"CrmCalls"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'appel CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expédition marquée comme non faite avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCall"),
     *             @OA\Property(property="message", type="string", example="Expédition marquée comme non faite avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appel CRM non trouvé"
     *     )
     * )
     */
    public function markShippingUndone(CrmCall $crmCall): JsonResponse
    {
        $crmCall->update(['shipping_done' => 0]);

        $crmCall->load(['customer', 'techtabletSeller', 'crmCallsStatus']);

        return response()->json([
            'success' => true,
            'data' => $crmCall,
            'message' => 'Expédition marquée comme non faite avec succès.',
        ]);
    }
}