<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLocationRequest\StoreCustomerLocationRequest;
use App\Http\Requests\CustomerLocationRequest\UpdateCustomerLocationRequest;
use App\Models\CustomerLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerLocations",
 *     description="Opérations CRUD pour les localisations clients"
 * )
 */
class CustomerLocationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-locations",
     *     summary="Liste toutes les localisations clients",
     *     tags={"CustomerLocations"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des localisations clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerLocation")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des localisations clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerLocations = CustomerLocation::all();

        return response()->json([
            'success' => true,
            'data' => $customerLocations,
            'message' => 'Liste des localisations clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-locations/{id}",
     *     summary="Affiche les détails d'une localisation client spécifique",
     *     tags={"CustomerLocations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la localisation client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Localisation client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLocation"),
     *             @OA\Property(property="message", type="string", example="Localisation client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Localisation client non trouvée"
     *     )
     * )
     */
    public function show(CustomerLocation $customerLocation): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerLocation,
            'message' => 'Localisation client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-locations",
     *     summary="Crée une nouvelle localisation client",
     *     tags={"CustomerLocations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Localisation client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLocation"),
     *             @OA\Property(property="message", type="string", example="Localisation client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerLocationRequest $request): JsonResponse
    {
        $customerLocation = CustomerLocation::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerLocation,
            'message' => 'Localisation client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-locations/{id}",
     *     summary="Met à jour une localisation client existante",
     *     tags={"CustomerLocations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la localisation client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Localisation client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLocation"),
     *             @OA\Property(property="message", type="string", example="Localisation client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Localisation client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerLocationRequest $request, CustomerLocation $customerLocation): JsonResponse
    {
        $customerLocation->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerLocation,
            'message' => 'Localisation client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-locations/{id}",
     *     summary="Supprime une localisation client",
     *     tags={"CustomerLocations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la localisation client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Localisation client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Localisation client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Localisation client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerLocation $customerLocation): JsonResponse
    {
        $customerLocation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Localisation client supprimée avec succès.',
        ]);
    }
}