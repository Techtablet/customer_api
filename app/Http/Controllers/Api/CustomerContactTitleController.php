<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerContactTitleRequest\StoreCustomerContactTitleRequest;
use App\Http\Requests\CustomerContactTitleRequest\UpdateCustomerContactTitleRequest;
use App\Models\CustomerContactTitle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerContactTitles",
 *     description="Opérations CRUD pour les civilités clients"
 * )
 */
class CustomerContactTitleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-contact-titles",
     *     summary="Liste toutes les civilités clients",
     *     tags={"CustomerContactTitles"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des civilités clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContactTitle")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des civilités clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerContactTitles = CustomerContactTitle::all();

        return response()->json([
            'success' => true,
            'data' => $customerContactTitles,
            'message' => 'Liste des civilités clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contact-titles/{id}",
     *     summary="Affiche les détails d'une civilité client spécifique",
     *     tags={"CustomerContactTitles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Civilité client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactTitle"),
     *             @OA\Property(property="message", type="string", example="Civilité client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité client non trouvée"
     *     )
     * )
     */
    public function show(CustomerContactTitle $customerContactTitle): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerContactTitle,
            'message' => 'Civilité client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-contact-titles",
     *     summary="Crée une nouvelle civilité client",
     *     tags={"CustomerContactTitles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerContactTitleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Civilité client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactTitle"),
     *             @OA\Property(property="message", type="string", example="Civilité client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerContactTitleRequest $request): JsonResponse
    {
        $customerContactTitle = CustomerContactTitle::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerContactTitle,
            'message' => 'Civilité client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-contact-titles/{id}",
     *     summary="Met à jour une civilité client existante",
     *     tags={"CustomerContactTitles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerContactTitleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Civilité client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactTitle"),
     *             @OA\Property(property="message", type="string", example="Civilité client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerContactTitleRequest $request, CustomerContactTitle $customerContactTitle): JsonResponse
    {
        $customerContactTitle->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerContactTitle,
            'message' => 'Civilité client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-contact-titles/{id}",
     *     summary="Supprime une civilité client",
     *     tags={"CustomerContactTitles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Civilité client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Civilité client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerContactTitle $customerContactTitle): JsonResponse
    {
        $customerContactTitle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Civilité client supprimée avec succès.',
        ]);
    }
}