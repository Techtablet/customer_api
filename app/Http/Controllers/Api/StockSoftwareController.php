<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockSoftware;
use App\Http\Requests\StockSoftwareRequest\StoreStockSoftwareRequest;
use App\Http\Requests\StockSoftwareRequest\UpdateStockSoftwareRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="StockSoftware",
 *     description="API pour gérer les logiciels disponibles"
 * )
 */
class StockSoftwareController extends Controller
{
    /**
     * Liste tous les logiciels
     *
     * @OA\Get(
     *     path="/stock-softwares",
     *     tags={"StockSoftware"},
     *     summary="Liste tous les logiciels",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des logiciels récupérée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liste des logiciels récupérée avec succès"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/StockSoftware")
     *             )
     *         )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $softwares = StockSoftware::all();

        return response()->json([
            'success' => true,
            'message' => 'Liste des logiciels récupérée avec succès',
            'data' => $softwares
        ]);
    }

    /**
     * Crée un nouveau logiciel
     *
     * @OA\Post(
     *     path="/stock-softwares",
     *     tags={"StockSoftware"},
     *     summary="Créer un logiciel",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StockSoftware")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Logiciel créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logiciel créé avec succès"),
     *             @OA\Property(property="data", ref="#/components/schemas/StockSoftware")
     *         )
     *     )
     * )
     *
     * @param StoreStockSoftwareRequest $request
     * @return JsonResponse
     */
    public function store(StoreStockSoftwareRequest $request): JsonResponse
    {
        $software = StockSoftware::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Logiciel créé avec succès',
            'data' => $software
        ], 201);
    }

    /**
     * Affiche un logiciel par ID
     *
     * @OA\Get(
     *     path="/stock-softwares/{id}",
     *     tags={"StockSoftware"},
     *     summary="Afficher un logiciel par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du logiciel",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logiciel récupéré avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logiciel récupéré avec succès"),
     *             @OA\Property(property="data", ref="#/components/schemas/StockSoftware")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Logiciel non trouvé")
     * )
     *
     * @param StockSoftware $stockSoftware
     * @return JsonResponse
     */
    public function show(StockSoftware $stockSoftware): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Logiciel récupéré avec succès',
            'data' => $stockSoftware
        ]);
    }

    /**
     * Met à jour un logiciel
     *
     * @OA\Put(
     *     path="/stock-softwares/{id}",
     *     tags={"StockSoftware"},
     *     summary="Mettre à jour un logiciel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du logiciel",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StockSoftware")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logiciel mis à jour avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logiciel mis à jour avec succès"),
     *             @OA\Property(property="data", ref="#/components/schemas/StockSoftware")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Logiciel non trouvé")
     * )
     *
     * @param UpdateStockSoftwareRequest $request
     * @param StockSoftware $stockSoftware
     * @return JsonResponse
     */
    public function update(UpdateStockSoftwareRequest $request, StockSoftware $stockSoftware): JsonResponse
    {
        $stockSoftware->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Logiciel mis à jour avec succès',
            'data' => $stockSoftware
        ]);
    }

    /**
     * Supprime un logiciel
     *
     * @OA\Delete(
     *     path="/stock-softwares/{id}",
     *     tags={"StockSoftware"},
     *     summary="Supprimer un logiciel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du logiciel",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logiciel supprimé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logiciel supprimé avec succès")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Logiciel non trouvé")
     * )
     *
     * @param StockSoftware $stockSoftware
     * @return JsonResponse
     */
    public function destroy(StockSoftware $stockSoftware): JsonResponse
    {
        $stockSoftware->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logiciel supprimé avec succès'
        ]);
    }
}
