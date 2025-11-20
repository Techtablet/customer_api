<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLangRequest\StoreCustomerLangRequest;
use App\Http\Requests\CustomerLangRequest\UpdateCustomerLangRequest;
use App\Models\CustomerLang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerLangs",
 *     description="Opérations CRUD pour les langues clients"
 * )
 */
class CustomerLangController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-langs",
     *     summary="Liste toutes les langues clients",
     *     tags={"CustomerLangs"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des langues clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerLang")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des langues clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerLangs = CustomerLang::all();

        return response()->json([
            'success' => true,
            'data' => $customerLangs,
            'message' => 'Liste des langues clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-langs/{id}",
     *     summary="Affiche les détails d'une langue client spécifique",
     *     tags={"CustomerLangs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la langue client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Langue client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLang"),
     *             @OA\Property(property="message", type="string", example="Langue client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Langue client non trouvée"
     *     )
     * )
     */
    public function show(CustomerLang $customerLang): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerLang,
            'message' => 'Langue client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-langs",
     *     summary="Crée une nouvelle langue client",
     *     tags={"CustomerLangs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerLangRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Langue client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLang"),
     *             @OA\Property(property="message", type="string", example="Langue client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerLangRequest $request): JsonResponse
    {
        $customerLang = CustomerLang::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerLang,
            'message' => 'Langue client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-langs/{id}",
     *     summary="Met à jour une langue client existante",
     *     tags={"CustomerLangs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la langue client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerLangRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Langue client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerLang"),
     *             @OA\Property(property="message", type="string", example="Langue client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Langue client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerLangRequest $request, CustomerLang $customerLang): JsonResponse
    {
        $customerLang->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerLang,
            'message' => 'Langue client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-langs/{id}",
     *     summary="Supprime une langue client",
     *     tags={"CustomerLangs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la langue client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Langue client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Langue client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Langue client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerLang $customerLang): JsonResponse
    {
        $customerLang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Langue client supprimée avec succès.',
        ]);
    }
}