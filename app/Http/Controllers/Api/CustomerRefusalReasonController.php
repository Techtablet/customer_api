<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRefusalReasonRequest\StoreCustomerRefusalReasonRequest;
use App\Http\Requests\CustomerRefusalReasonRequest\UpdateCustomerRefusalReasonRequest;
use App\Models\CustomerRefusalReason;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerRefusalReasons",
 *     description="Opérations CRUD pour les raisons de refus clients"
 * )
 */
class CustomerRefusalReasonController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-refusal-reasons",
     *     summary="Liste toutes les raisons de refus clients",
     *     tags={"CustomerRefusalReasons"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des raisons de refus clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerRefusalReason")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des raisons de refus clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerRefusalReasons = CustomerRefusalReason::all();

        return response()->json([
            'success' => true,
            'data' => $customerRefusalReasons,
            'message' => 'Liste des raisons de refus clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-refusal-reasons/{id}",
     *     summary="Affiche les détails d'une raison de refus client spécifique",
     *     tags={"CustomerRefusalReasons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la raison de refus client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Raison de refus client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerRefusalReason"),
     *             @OA\Property(property="message", type="string", example="Raison de refus client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Raison de refus client non trouvée"
     *     )
     * )
     */
    public function show(CustomerRefusalReason $customerRefusalReason): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerRefusalReason,
            'message' => 'Raison de refus client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-refusal-reasons",
     *     summary="Crée une nouvelle raison de refus client",
     *     tags={"CustomerRefusalReasons"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerRefusalReasonRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Raison de refus client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerRefusalReason"),
     *             @OA\Property(property="message", type="string", example="Raison de refus client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerRefusalReasonRequest $request): JsonResponse
    {
        $customerRefusalReason = CustomerRefusalReason::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerRefusalReason,
            'message' => 'Raison de refus client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-refusal-reasons/{id}",
     *     summary="Met à jour une raison de refus client existante",
     *     tags={"CustomerRefusalReasons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la raison de refus client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerRefusalReasonRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Raison de refus client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerRefusalReason"),
     *             @OA\Property(property="message", type="string", example="Raison de refus client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Raison de refus client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerRefusalReasonRequest $request, CustomerRefusalReason $customerRefusalReason): JsonResponse
    {
        $customerRefusalReason->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerRefusalReason,
            'message' => 'Raison de refus client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-refusal-reasons/{id}",
     *     summary="Supprime une raison de refus client",
     *     tags={"CustomerRefusalReasons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la raison de refus client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Raison de refus client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Raison de refus client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Raison de refus client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerRefusalReason $customerRefusalReason): JsonResponse
    {
        $customerRefusalReason->delete();

        return response()->json([
            'success' => true,
            'message' => 'Raison de refus client supprimée avec succès.',
        ]);
    }
}