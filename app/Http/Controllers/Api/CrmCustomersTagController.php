<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmCustomersTagRequest\StoreCrmCustomersTagRequest;
use App\Http\Requests\CrmCustomersTagRequest\UpdateCrmCustomersTagRequest;
use App\Models\CrmCustomersTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CrmCustomersTags",
 *     description="Opérations CRUD pour les liaisons entre clients et tags CRM"
 * )
 */
class CrmCustomersTagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/crm-customers-tags",
     *     summary="Liste toutes les liaisons clients-tags CRM",
     *     tags={"CrmCustomersTags"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des liaisons récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTag")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des liaisons clients-tags CRM récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $crmCustomersTags = CrmCustomersTag::with(['crmTag', 'customer'])->get();

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTags,
            'message' => 'Liste des liaisons clients-tags CRM récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags/{id}",
     *     summary="Affiche les détails d'une liaison spécifique",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison client-tag CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTag"),
     *             @OA\Property(property="message", type="string", example="Liaison client-tag CRM récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     )
     * )
     */
    public function show(CrmCustomersTag $crmCustomersTag): JsonResponse
    {
        $crmCustomersTag->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTag,
            'message' => 'Liaison client-tag CRM récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags/customer/{customerId}",
     *     summary="Récupère les tags d'un client spécifique",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tags du client récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTag")
     *             ),
     *             @OA\Property(property="message", type="string", example="Tags du client récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun tag trouvé pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $crmCustomersTags = CrmCustomersTag::where('id_customer', $customerId)
            ->with(['crmTag', 'customer'])
            ->get();

        if ($crmCustomersTags->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun tag trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTags,
            'message' => 'Tags du client récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-customers-tags/tag/{tagId}",
     *     summary="Récupère les clients ayant un tag spécifique",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="tagId",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Clients avec ce tag récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCustomersTag")
     *             ),
     *             @OA\Property(property="message", type="string", example="Clients avec ce tag récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun client trouvé avec ce tag"
     *     )
     * )
     */
    public function showByTag($tagId): JsonResponse
    {
        $crmCustomersTags = CrmCustomersTag::where('id_crm_tag', $tagId)
            ->with(['crmTag', 'customer'])
            ->get();

        if ($crmCustomersTags->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun client trouvé avec ce tag.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTags,
            'message' => 'Clients avec ce tag récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/crm-customers-tags",
     *     summary="Crée une nouvelle liaison client-tag CRM",
     *     tags={"CrmCustomersTags"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCrmCustomersTagRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Liaison créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTag"),
     *             @OA\Property(property="message", type="string", example="Liaison client-tag CRM créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCrmCustomersTagRequest $request): JsonResponse
    {
        $crmCustomersTag = CrmCustomersTag::create($request->validated());

        $crmCustomersTag->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTag,
            'message' => 'Liaison client-tag CRM créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/crm-customers-tags/{id}",
     *     summary="Met à jour une liaison existante",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCrmCustomersTagRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCustomersTag"),
     *             @OA\Property(property="message", type="string", example="Liaison client-tag CRM mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCrmCustomersTagRequest $request, CrmCustomersTag $crmCustomersTag): JsonResponse
    {
        $crmCustomersTag->update($request->validated());

        $crmCustomersTag->load(['crmTag', 'customer']);

        return response()->json([
            'success' => true,
            'data' => $crmCustomersTag,
            'message' => 'Liaison client-tag CRM mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-customers-tags/{id}",
     *     summary="Supprime une liaison",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liaison client-tag CRM supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     )
     * )
     */
    public function destroy(CrmCustomersTag $crmCustomersTag): JsonResponse
    {
        $crmCustomersTag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Liaison client-tag CRM supprimée avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-customers-tags/customer/{customerId}/tag/{tagId}",
     *     summary="Supprime une liaison spécifique par client et tag",
     *     tags={"CrmCustomersTags"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tagId",
     *         in="path",
     *         required=true,
     *         description="ID du tag",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liaison client-tag CRM supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     )
     * )
     */
    public function destroyByCustomerAndTag($customerId, $tagId): JsonResponse
    {
        $crmCustomersTag = CrmCustomersTag::where('id_customer', $customerId)
            ->where('id_crm_tag', $tagId)
            ->firstOrFail();

        $crmCustomersTag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Liaison client-tag CRM supprimée avec succès.',
        ]);
    }
}