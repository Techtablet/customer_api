<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCountryRequest\StoreCustomerCountryRequest;
use App\Http\Requests\CustomerCountryRequest\UpdateCustomerCountryRequest;
use App\Models\CustomerCountry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerCountries",
 *     description="Opérations CRUD pour les pays clients"
 * )
 */
class CustomerCountryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-countries",
     *     summary="Liste tous les pays clients",
     *     tags={"CustomerCountries"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des pays clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerCountry")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des pays clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerCountries = CustomerCountry::all();

        return response()->json([
            'success' => true,
            'data' => $customerCountries,
            'message' => 'Liste des pays clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-countries/{id}",
     *     summary="Affiche les détails d'un pays client spécifique",
     *     tags={"CustomerCountries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du pays client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pays client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCountry"),
     *             @OA\Property(property="message", type="string", example="Pays client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pays client non trouvé"
     *     )
     * )
     */
    public function show(CustomerCountry $customerCountry): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerCountry,
            'message' => 'Pays client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-countries",
     *     summary="Crée un nouveau pays client",
     *     tags={"CustomerCountries"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerCountryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pays client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCountry"),
     *             @OA\Property(property="message", type="string", example="Pays client créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerCountryRequest $request): JsonResponse
    {
        $customerCountry = CustomerCountry::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerCountry,
            'message' => 'Pays client créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-countries/{id}",
     *     summary="Met à jour un pays client existant",
     *     tags={"CustomerCountries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du pays client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerCountryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pays client mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCountry"),
     *             @OA\Property(property="message", type="string", example="Pays client mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pays client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerCountryRequest $request, CustomerCountry $customerCountry): JsonResponse
    {
        $customerCountry->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerCountry,
            'message' => 'Pays client mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-countries/{id}",
     *     summary="Supprime un pays client",
     *     tags={"CustomerCountries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du pays client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pays client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pays client supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pays client non trouvé"
     *     )
     * )
     */
    public function destroy(CustomerCountry $customerCountry): JsonResponse
    {
        $customerCountry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pays client supprimé avec succès.',
        ]);
    }
}