<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechtabletSellerRequest\StoreTechtabletSellerRequest;
use App\Http\Requests\TechtabletSellerRequest\UpdateTechtabletSellerRequest;
use App\Models\TechtabletSeller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="TechtabletSellers",
 *     description="Opérations CRUD pour les vendeurs Techtablet"
 * )
 */
class TechtabletSellerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/techtablet-sellers",
     *     summary="Liste tous les vendeurs Techtablet",
     *     tags={"TechtabletSellers"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des vendeurs Techtablet récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/TechtabletSeller")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des vendeurs Techtablet récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $techtabletSellers = TechtabletSeller::all();

        return response()->json([
            'success' => true,
            'data' => $techtabletSellers,
            'message' => 'Liste des vendeurs Techtablet récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/techtablet-sellers/{id}",
     *     summary="Affiche les détails d'un vendeur Techtablet spécifique",
     *     tags={"TechtabletSellers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du vendeur Techtablet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vendeur Techtablet récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/TechtabletSeller"),
     *             @OA\Property(property="message", type="string", example="Vendeur Techtablet récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vendeur Techtablet non trouvé"
     *     )
     * )
     */
    public function show(TechtabletSeller $techtabletSeller): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $techtabletSeller,
            'message' => 'Vendeur Techtablet récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/techtablet-sellers",
     *     summary="Crée un nouveau vendeur Techtablet",
     *     tags={"TechtabletSellers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTechtabletSellerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vendeur Techtablet créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/TechtabletSeller"),
     *             @OA\Property(property="message", type="string", example="Vendeur Techtablet créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreTechtabletSellerRequest $request): JsonResponse
    {
        $techtabletSeller = TechtabletSeller::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $techtabletSeller,
            'message' => 'Vendeur Techtablet créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/techtablet-sellers/{id}",
     *     summary="Met à jour un vendeur Techtablet existant",
     *     tags={"TechtabletSellers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du vendeur Techtablet à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTechtabletSellerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vendeur Techtablet mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/TechtabletSeller"),
     *             @OA\Property(property="message", type="string", example="Vendeur Techtablet mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vendeur Techtablet non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateTechtabletSellerRequest $request, TechtabletSeller $techtabletSeller): JsonResponse
    {
        $techtabletSeller->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $techtabletSeller,
            'message' => 'Vendeur Techtablet mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/techtablet-sellers/{id}",
     *     summary="Supprime un vendeur Techtablet",
     *     tags={"TechtabletSellers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du vendeur Techtablet à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vendeur Techtablet supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Vendeur Techtablet supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vendeur Techtablet non trouvé"
     *     )
     * )
     */
    public function destroy(TechtabletSeller $techtabletSeller): JsonResponse
    {
        $techtabletSeller->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendeur Techtablet supprimé avec succès.',
        ]);
    }
}