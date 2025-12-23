<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmCallsStatusRequest\StoreCrmCallsStatusRequest;
use App\Http\Requests\CrmCallsStatusRequest\UpdateCrmCallsStatusRequest;
use App\Models\CrmCallsStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CrmCallsStatuses",
 *     description="Opérations CRUD pour les statuts d'appels CRM"
 * )
 */
class CrmCallsStatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/crm-calls-statuses",
     *     summary="Liste tous les statuts d'appels CRM avec pagination",
     *     tags={"CrmCallsStatuses"},
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
     *         description="Liste paginée des statuts d'appels CRM récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCallsStatus")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 ref="#/components/schemas/PaginationMeta"
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des statuts d'appels CRM récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 100), 100);
        
        $crmCallsStatuses = CrmCallsStatus::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $crmCallsStatuses->items(),
            'pagination' => [
                'current_page' => $crmCallsStatuses->currentPage(),
                'per_page' => $crmCallsStatuses->perPage(),
                'total' => $crmCallsStatuses->total(),
                'last_page' => $crmCallsStatuses->lastPage(),
                'from' => $crmCallsStatuses->firstItem(),
                'to' => $crmCallsStatuses->lastItem(),
            ],
            'message' => 'Liste des statuts d\'appels CRM récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls-statuses/{id}",
     *     summary="Affiche les détails d'un statut d'appel CRM spécifique",
     *     tags={"CrmCallsStatuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut d'appel CRM",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut d'appel CRM récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCallsStatus"),
     *             @OA\Property(property="message", type="string", example="Statut d'appel CRM récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut d'appel CRM non trouvé"
     *     )
     * )
     */
    public function show(CrmCallsStatus $crmCallsStatus): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $crmCallsStatus,
            'message' => 'Statut d\'appel CRM récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/crm-calls-statuses",
     *     summary="Crée un nouveau statut d'appel CRM",
     *     tags={"CrmCallsStatuses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCrmCallsStatusRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Statut d'appel CRM créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCallsStatus"),
     *             @OA\Property(property="message", type="string", example="Statut d'appel CRM créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCrmCallsStatusRequest $request): JsonResponse
    {
        $crmCallsStatus = CrmCallsStatus::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $crmCallsStatus,
            'message' => 'Statut d\'appel CRM créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/crm-calls-statuses/{id}",
     *     summary="Met à jour un statut d'appel CRM existant",
     *     tags={"CrmCallsStatuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut d'appel CRM à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCrmCallsStatusRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut d'appel CRM mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CrmCallsStatus"),
     *             @OA\Property(property="message", type="string", example="Statut d'appel CRM mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut d'appel CRM non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCrmCallsStatusRequest $request, CrmCallsStatus $crmCallsStatus): JsonResponse
    {
        $crmCallsStatus->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $crmCallsStatus,
            'message' => 'Statut d\'appel CRM mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/crm-calls-statuses/{id}",
     *     summary="Supprime un statut d'appel CRM",
     *     tags={"CrmCallsStatuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut d'appel CRM à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut d'appel CRM supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Statut d'appel CRM supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut d'appel CRM non trouvé"
     *     )
     * )
     */
    public function destroy(CrmCallsStatus $crmCallsStatus): JsonResponse
    {
        $crmCallsStatus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Statut d\'appel CRM supprimé avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/crm-calls-statuses/search/{name}",
     *     summary="Recherche des statuts d'appels CRM par nom",
     *     tags={"CrmCallsStatuses"},
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         required=true,
     *         description="Nom ou partie du nom à rechercher",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statuts d'appels CRM trouvés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CrmCallsStatus")
     *             ),
     *             @OA\Property(property="message", type="string", example="Statuts d'appels CRM trouvés avec succès.")
     *         )
     *     )
     * )
     */
    public function search($name): JsonResponse
    {
        $crmCallsStatuses = CrmCallsStatus::where('name', 'like', '%' . $name . '%')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $crmCallsStatuses,
            'message' => 'Statuts d\'appels CRM trouvés avec succès.',
        ]);
    }
}