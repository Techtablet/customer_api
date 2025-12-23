<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmTagRequest\StoreCrmTagRequest;
use App\Http\Requests\CrmTagRequest\UpdateCrmTagRequest;
use App\Models\CrmTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CrmTags",
 *     description="Opérations CRUD pour les tags CRM"
 * )
 */
class CrmTagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/crm-tags",
     *     summary="Liste tous les tags CRM avec pagination",
     *     tags={"CrmTags"},
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
     *         description="Liste paginée des tags CRM récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmTag")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 ref="#/components/schemas/PaginationMeta"
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des tags CRM récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 100), 100);
        
        $crmTags = CrmTag::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $crmTags->items(),
            'pagination' => [
                'current_page' => $crmTags->currentPage(),
                'per_page' => $crmTags->perPage(),
                'total' => $crmTags->total(),
                'last_page' => $crmTags->lastPage(),
                'from' => $crmTags->firstItem(),
                'to' => $crmTags->lastItem(),
            ],
            'message' => 'Liste des tags CRM récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-tags/active",
     *     summary="Liste tous les tags CRM actifs",
     *     tags={"CrmTags"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des tags CRM actifs récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmTag")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des tags CRM actifs récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function indexActive(): JsonResponse
    {
        $crmTags = CrmTag::active()->get();

        return response()->json([
            'success' => true,
            'data' => $crmTags,
            'message' => 'Liste des tags CRM actifs récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-tags/inactive",
     *     summary="Liste tous les tags CRM inactifs",
     *     tags={"CrmTags"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des tags CRM inactifs récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmTag")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des tags CRM inactifs récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function indexInactive(): JsonResponse
    {
        $crmTags = CrmTag::inactive()->get();

        return response()->json([
            'success' => true,
            'data' => $crmTags,
            'message' => 'Liste des tags CRM inactifs récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-tags/{id}",
     *     summary="Affiche les détails d'un tag CRM spécifique",
     *     tags={"CrmTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag CRM récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmTag"),
     *             @OA\Property(property="message", type="string", example="Tag CRM récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag CRM non trouvé"
     *     )
     * )
     */
    public function show(CrmTag $crmTag): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $crmTag,
            'message' => 'Tag CRM récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/crm-tags",
     *     summary="Crée un nouveau tag CRM",
     *     tags={"CrmTags"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCrmTagRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tag CRM créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmTag"),
     *             @OA\Property(property="message", type="string", example="Tag CRM créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCrmTagRequest $request): JsonResponse
    {
        $crmTag = CrmTag::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $crmTag,
            'message' => 'Tag CRM créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/crm-tags/{id}",
     *     summary="Met à jour un tag CRM existant",
     *     tags={"CrmTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCrmTagRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag CRM mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmTag"),
     *             @OA\Property(property="message", type="string", example="Tag CRM mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag CRM non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCrmTagRequest $request, CrmTag $crmTag): JsonResponse
    {
        $crmTag->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $crmTag,
            'message' => 'Tag CRM mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-tags/{id}",
     *     summary="Supprime un tag CRM",
     *     tags={"CrmTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag CRM supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Tag CRM supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag CRM non trouvé"
     *     )
     * )
     */
    public function destroy(CrmTag $crmTag): JsonResponse
    {
        $crmTag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag CRM supprimé avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/crm-tags/{id}/activate",
     *     summary="Active un tag CRM",
     *     tags={"CrmTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM à activer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag CRM activé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmTag"),
     *             @OA\Property(property="message", type="string", example="Tag CRM activé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag CRM non trouvé"
     *     )
     * )
     */
    public function activate(CrmTag $crmTag): JsonResponse
    {
        $crmTag->update(['inactive' => false]);

        return response()->json([
            'success' => true,
            'data' => $crmTag,
            'message' => 'Tag CRM activé avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/crm-tags/{id}/deactivate",
     *     summary="Désactive un tag CRM",
     *     tags={"CrmTags"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du tag CRM à désactiver",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag CRM désactivé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmTag"),
     *             @OA\Property(property="message", type="string", example="Tag CRM désactivé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag CRM non trouvé"
     *     )
     * )
     */
    public function deactivate(CrmTag $crmTag): JsonResponse
    {
        $crmTag->update(['inactive' => true]);

        return response()->json([
            'success' => true,
            'data' => $crmTag,
            'message' => 'Tag CRM désactivé avec succès.',
        ]);
    }
}