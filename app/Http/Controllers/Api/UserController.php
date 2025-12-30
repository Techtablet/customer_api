<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Opérations CRUD pour les utilisateurs"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Liste tous les utilisateurs",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des utilisateurs récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Liste des utilisateurs récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Affiche les détails d'un utilisateur spécifique",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="Utilisateur récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/users/admins",
     *     summary="Liste tous les administrateurs",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des administrateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des administrateurs récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function indexAdmins(): JsonResponse
    {
        $admins = User::admins()->get();

        return response()->json([
            'success' => true,
            'data' => $admins,
            'message' => 'Liste des administrateurs récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/users/customers",
     *     summary="Liste tous les clients",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des clients récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function indexCustomers(): JsonResponse
    {
        $customers = User::customers()->get();

        return response()->json([
            'success' => true,
            'data' => $customers,
            'message' => 'Liste des clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Crée un nouvel utilisateur",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="Utilisateur créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Met à jour un utilisateur existant",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="Utilisateur mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();
        
        // Si un nouveau mot de passe est fourni, le hacher
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Supprime un utilisateur",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Utilisateur supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/users/email/{email}",
     *     summary="Recherche un utilisateur par email",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         description="Email de l'utilisateur",
     *         @OA\Schema(type="string", format="email")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur trouvé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="Utilisateur trouvé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function findByEmail($email): JsonResponse
    {
        $user = User::where('email', $email)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur trouvé avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/users/{id}/verify-email",
     *     summary="Vérifie l'email d'un utilisateur",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email vérifié avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/User"),
     *             @OA\Property(property="message", type="string", example="Email vérifié avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function verifyEmail(User $user): JsonResponse
    {
        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Cet email est déjà vérifié.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Email vérifié avec succès.',
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/users/{id}/change-password",
     *     summary="Change le mot de passe d'un utilisateur",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"password"},
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="Nouveau mot de passe",
     *                 example="NewSecret123!"
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mot de passe changé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Mot de passe changé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function changePassword(User $user): JsonResponse
    {
        $request = request();
        
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe changé avec succès.',
        ]);
    }
}