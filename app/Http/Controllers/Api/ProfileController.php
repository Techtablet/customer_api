<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest\StoreProfileRequest;
use App\Http\Requests\ProfileRequest\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Profiles",
 *     description="Opérations CRUD pour les profils"
 * )
 */
class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profiles",
     *     summary="Liste tous les profils",
     *     tags={"Profiles"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des profils récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Profile")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des profils récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $profiles = Profile::all();

        return response()->json([
            'success' => true,
            'data' => $profiles,
            'message' => 'Liste des profils récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/profiles/{id}",
     *     summary="Affiche les détails d'un profil spécifique",
     *     tags={"Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du profil",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Profile"),
     *             @OA\Property(property="message", type="string", example="Profil récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profil non trouvé"
     *     )
     * )
     */
    public function show(Profile $profile): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $profile,
            'message' => 'Profil récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/profiles",
     *     summary="Crée un nouveau profil",
     *     tags={"Profiles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProfileRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Profile"),
     *             @OA\Property(property="message", type="string", example="Profil créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profile = Profile::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $profile,
            'message' => 'Profil créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/profiles/{id}",
     *     summary="Met à jour un profil existant",
     *     tags={"Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du profil à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProfileRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Profile"),
     *             @OA\Property(property="message", type="string", example="Profil mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profil non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        $profile->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $profile,
            'message' => 'Profil mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/profiles/{id}",
     *     summary="Supprime un profil",
     *     tags={"Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du profil à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Profil supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profil non trouvé"
     *     )
     * )
     */
    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Profil supprimé avec succès.',
        ]);
    }
}