<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest\StoreStoreGroupRequest;
use App\Http\Requests\StoreGroupRequest\UpdateStoreGroupRequest;
use App\Models\StoreGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="StoreGroups",
 *     description="Opérations CRUD pour les groupes de magasins"
 * )
 */
class StoreGroupController extends Controller
{
    /**
     * @OA\Get(
     *     path="/store-groups",
     *     summary="Liste tous les groupes de magasins",
     *     tags={"StoreGroups"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des groupes de magasins récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/StoreGroup")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des groupes de magasins récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $storeGroups = StoreGroup::all();

        return response()->json([
            'success' => true,
            'data' => $storeGroups,
            'message' => 'Liste des groupes de magasins récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/store-groups/{id}",
     *     summary="Affiche les détails d'un groupe de magasins spécifique",
     *     tags={"StoreGroups"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du groupe de magasins",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Groupe de magasins récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreGroup"),
     *             @OA\Property(property="message", type="string", example="Groupe de magasins récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Groupe de magasins non trouvé"
     *     )
     * )
     */
    public function show(StoreGroup $storeGroup): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $storeGroup,
            'message' => 'Groupe de magasins récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/store-groups",
     *     summary="Crée un nouveau groupe de magasins",
     *     tags={"StoreGroups"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreStoreGroupRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Groupe de magasins créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreGroup"),
     *             @OA\Property(property="message", type="string", example="Groupe de magasins créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreStoreGroupRequest $request): JsonResponse
    {
        $storeGroup = StoreGroup::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $storeGroup,
            'message' => 'Groupe de magasins créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/store-groups/{id}",
     *     summary="Met à jour un groupe de magasins existant",
     *     tags={"StoreGroups"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du groupe de magasins à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateStoreGroupRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Groupe de magasins mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/StoreGroup"),
     *             @OA\Property(property="message", type="string", example="Groupe de magasins mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Groupe de magasins non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateStoreGroupRequest $request, StoreGroup $storeGroup): JsonResponse
    {
        $storeGroup->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $storeGroup,
            'message' => 'Groupe de magasins mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/store-groups/{id}",
     *     summary="Supprime un groupe de magasins",
     *     tags={"StoreGroups"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du groupe de magasins à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Groupe de magasins supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Groupe de magasins supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Groupe de magasins non trouvé"
     *     )
     * )
     */
    public function destroy(StoreGroup $storeGroup): JsonResponse
    {
        $storeGroup->delete();

        return response()->json([
            'success' => true,
            'message' => 'Groupe de magasins supprimé avec succès.',
        ]);
    }
}