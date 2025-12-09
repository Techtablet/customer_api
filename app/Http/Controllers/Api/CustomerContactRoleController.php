<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerContactRoleRequest\StoreCustomerContactRoleRequest;
use App\Http\Requests\CustomerContactRoleRequest\UpdateCustomerContactRoleRequest;
use App\Models\CustomerContactRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerContactRoles",
 *     description="Opérations CRUD pour les rôles de contacts clients"
 * )
 */
class CustomerContactRoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-contact-roles",
     *     summary="Liste tous les rôles de contacts clients",
     *     tags={"CustomerContactRoles"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des rôles de contacts clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContactRole")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des rôles de contacts clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerContactRoles = CustomerContactRole::all();

        return response()->json([
            'success' => true,
            'data' => $customerContactRoles,
            'message' => 'Liste des rôles de contacts clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contact-roles/{id}",
     *     summary="Affiche les détails d'un rôle de contact client spécifique",
     *     tags={"CustomerContactRoles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du rôle de contact client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rôle de contact client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactRole"),
     *             @OA\Property(property="message", type="string", example="Rôle de contact client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rôle de contact client non trouvé"
     *     )
     * )
     */
    public function show(CustomerContactRole $customerContactRole): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerContactRole,
            'message' => 'Rôle de contact client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-contact-roles",
     *     summary="Crée un nouveau rôle de contact client",
     *     tags={"CustomerContactRoles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerContactRoleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rôle de contact client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactRole"),
     *             @OA\Property(property="message", type="string", example="Rôle de contact client créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerContactRoleRequest $request): JsonResponse
    {
        $customerContactRole = CustomerContactRole::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerContactRole,
            'message' => 'Rôle de contact client créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-contact-roles/{id}",
     *     summary="Met à jour un rôle de contact client existant",
     *     tags={"CustomerContactRoles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du rôle de contact client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerContactRoleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rôle de contact client mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactRole"),
     *             @OA\Property(property="message", type="string", example="Rôle de contact client mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rôle de contact client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerContactRoleRequest $request, CustomerContactRole $customerContactRole): JsonResponse
    {
        $customerContactRole->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerContactRole,
            'message' => 'Rôle de contact client mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-contact-roles/{id}",
     *     summary="Supprime un rôle de contact client",
     *     tags={"CustomerContactRoles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du rôle de contact client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rôle de contact client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Rôle de contact client supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rôle de contact client non trouvé"
     *     )
     * )
     */
    public function destroy(CustomerContactRole $customerContactRole): JsonResponse
    {
        $customerContactRole->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rôle de contact client supprimé avec succès.',
        ]);
    }
}