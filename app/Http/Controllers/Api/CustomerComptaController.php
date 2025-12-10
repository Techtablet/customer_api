<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerComptaRequest\StoreCustomerComptaRequest;
use App\Http\Requests\CustomerComptaRequest\UpdateCustomerComptaRequest;
use App\Models\CustomerCompta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerComptas",
 *     description="Opérations CRUD pour les comptabilités clients"
 * )
 */
class CustomerComptaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-comptas",
     *     summary="Liste toutes les comptabilités clients",
     *     tags={"CustomerComptas"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des comptabilités clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerCompta")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des comptabilités clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerComptas = CustomerCompta::with('customer')->get();

        return response()->json([
            'success' => true,
            'data' => $customerComptas,
            'message' => 'Liste des comptabilités clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-comptas/{id}",
     *     summary="Affiche les détails d'une comptabilité client spécifique",
     *     tags={"CustomerComptas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la comptabilité client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comptabilité client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCompta"),
     *             @OA\Property(property="message", type="string", example="Comptabilité client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comptabilité client non trouvée"
     *     )
     * )
     */
    public function show(CustomerCompta $customerCompta): JsonResponse
    {
        $customerCompta->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerCompta,
            'message' => 'Comptabilité client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-comptas",
     *     summary="Crée une nouvelle comptabilité client",
     *     tags={"CustomerComptas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerComptaRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comptabilité client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCompta"),
     *             @OA\Property(property="message", type="string", example="Comptabilité client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerComptaRequest $request): JsonResponse
    {
        $customerCompta = CustomerCompta::create($request->validated());
        $customerCompta->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerCompta,
            'message' => 'Comptabilité client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-comptas/{id}",
     *     summary="Met à jour une comptabilité client existante",
     *     tags={"CustomerComptas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la comptabilité client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerComptaRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comptabilité client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCompta"),
     *             @OA\Property(property="message", type="string", example="Comptabilité client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comptabilité client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerComptaRequest $request, CustomerCompta $customerCompta): JsonResponse
    {
        $customerCompta->update($request->validated());
        $customerCompta->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerCompta,
            'message' => 'Comptabilité client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-comptas/{id}",
     *     summary="Supprime une comptabilité client",
     *     tags={"CustomerComptas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la comptabilité client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comptabilité client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comptabilité client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comptabilité client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerCompta $customerCompta): JsonResponse
    {
        $customerCompta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comptabilité client supprimée avec succès.',
        ]);
    }
}