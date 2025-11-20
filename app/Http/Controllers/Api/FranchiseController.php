<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FranchiseRequest\StoreFranchiseRequest;
use App\Http\Requests\FranchiseRequest\UpdateFranchiseRequest;
use App\Models\Franchise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Franchises",
 *     description="Opérations CRUD pour les franchises"
 * )
 */
class FranchiseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/franchises",
     *     summary="Liste toutes les franchises",
     *     tags={"Franchises"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des franchises récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id_franchise", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ma Franchise"),
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des franchises récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $franchises = Franchise::all();

        return response()->json([
            'success' => true,
            'data' => $franchises,
            'message' => 'Liste des franchises récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/franchises/{id}",
     *     summary="Affiche les détails d'une franchise spécifique",
     *     tags={"Franchises"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la franchise",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Franchise récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id_franchise", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Ma Franchise"),
     *             ),
     *             @OA\Property(property="message", type="string", example="Franchise récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Franchise non trouvée"
     *     )
     * )
     */
    public function show(Franchise $franchise): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $franchise,
            'message' => 'Franchise récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/franchises",
     *     summary="Crée une nouvelle franchise",
     *     tags={"Franchises"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", maxLength=30, example="Nouvelle Franchise")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Franchise créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id_franchise", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nouvelle Franchise"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ),
     *             @OA\Property(property="message", type="string", example="Franchise créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreFranchiseRequest $request): JsonResponse
    {
        $franchise = Franchise::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $franchise,
            'message' => 'Franchise créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/franchises/{id}",
     *     summary="Met à jour une franchise existante",
     *     tags={"Franchises"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la franchise à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=30, example="Franchise Modifiée")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Franchise mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id_franchise", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Franchise Modifiée"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ),
     *             @OA\Property(property="message", type="string", example="Franchise mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Franchise non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateFranchiseRequest $request, Franchise $franchise): JsonResponse
    {
        $franchise->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $franchise,
            'message' => 'Franchise mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/franchises/{id}",
     *     summary="Supprime une franchise",
     *     tags={"Franchises"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la franchise à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Franchise supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Franchise supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Franchise non trouvée"
     *     )
     * )
     */
    public function destroy(Franchise $franchise): JsonResponse
    {
        $franchise->delete();

        return response()->json([
            'success' => true,
            'message' => 'Franchise supprimée avec succès.',
        ]);
    }
}