<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCountryRequest\StoreCustomerCountryRequest;
use App\Http\Requests\CustomerCountryRequest\UpdateCustomerCountryRequest;
use App\Models\CustomerCountry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Services\CustomerCountryService;

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
     *    @OA\Parameter(
     *         name="is_intracom_vat",
     *         in="query",
     *         description="Filtrer les pays clients par statut de TVA intracommunautaire",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="format_data",
     *         in="query",
     *         description="Formater les données pour le gestionnaire de clients",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *    @OA\Parameter(
     *         name="format_data_for_shipping",
     *         in="query",
     *         description="Formater les données pour le shipping",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
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
    public function index(Request $request): JsonResponse
    {
        $customerCountries = CustomerCountry::orderBy('name');
        if ($request->has('is_intracom_vat') && $request->boolean('is_intracom_vat')) {
            $customerCountries->where('is_intracom_vat', true);
        }

        $customerCountries = $customerCountries->get();

        $data = $customerCountries;
        if ($request->has('format_data') && $request->boolean('format_data')) {
            $dataFormated = [];
            foreach ($customerCountries as $customerCountry) {
                $dataFormated[] = CustomerCountryService::format_data_for_customer_manager($customerCountry->toArray());
            }
            $data = $dataFormated;
        }

        if ($request->has('format_data_for_shipping') && $request->boolean('format_data_for_shipping')) {
            $dataFormated = [];
            foreach ($customerCountries as $customerCountry) {
                $dataFormated[] = CustomerCountryService::format_data_for_shipping($customerCountry->toArray());
            }
            $data = $dataFormated;
        }

        return response()->json([
            'success' => true,
            'data' => $data,
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