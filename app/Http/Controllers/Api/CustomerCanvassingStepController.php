<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCanvassingStepRequest\StoreCustomerCanvassingStepRequest;
use App\Http\Requests\CustomerCanvassingStepRequest\UpdateCustomerCanvassingStepRequest;
use App\Models\CustomerCanvassingStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerCanvassingSteps",
 *     description="Opérations CRUD pour les étapes de démarchage clients"
 * )
 */
class CustomerCanvassingStepController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-canvassing-steps",
     *     summary="Liste toutes les étapes de démarchage clients",
     *     tags={"CustomerCanvassingSteps"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des étapes de démarchage clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerCanvassingStep")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des étapes de démarchage clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerCanvassingSteps = CustomerCanvassingStep::orderBy('order')->get();

        return response()->json([
            'success' => true,
            'data' => $customerCanvassingSteps,
            'message' => 'Liste des étapes de démarchage clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-canvassing-steps/{id}",
     *     summary="Affiche les détails d'une étape de démarchage client spécifique",
     *     tags={"CustomerCanvassingSteps"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'étape de démarchage client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Étape de démarchage client récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCanvassingStep"),
     *             @OA\Property(property="message", type="string", example="Étape de démarchage client récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Étape de démarchage client non trouvée"
     *     )
     * )
     */
    public function show(CustomerCanvassingStep $customerCanvassingStep): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customerCanvassingStep,
            'message' => 'Étape de démarchage client récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-canvassing-steps",
     *     summary="Crée une nouvelle étape de démarchage client",
     *     tags={"CustomerCanvassingSteps"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerCanvassingStepRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Étape de démarchage client créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCanvassingStep"),
     *             @OA\Property(property="message", type="string", example="Étape de démarchage client créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerCanvassingStepRequest $request): JsonResponse
    {
        $customerCanvassingStep = CustomerCanvassingStep::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerCanvassingStep,
            'message' => 'Étape de démarchage client créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-canvassing-steps/{id}",
     *     summary="Met à jour une étape de démarchage client existante",
     *     tags={"CustomerCanvassingSteps"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'étape de démarchage client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerCanvassingStepRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Étape de démarchage client mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerCanvassingStep"),
     *             @OA\Property(property="message", type="string", example="Étape de démarchage client mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Étape de démarchage client non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerCanvassingStepRequest $request, CustomerCanvassingStep $customerCanvassingStep): JsonResponse
    {
        $customerCanvassingStep->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $customerCanvassingStep,
            'message' => 'Étape de démarchage client mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-canvassing-steps/{id}",
     *     summary="Supprime une étape de démarchage client",
     *     tags={"CustomerCanvassingSteps"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'étape de démarchage client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Étape de démarchage client supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Étape de démarchage client supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Étape de démarchage client non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerCanvassingStep $customerCanvassingStep): JsonResponse
    {
        $customerCanvassingStep->delete();

        return response()->json([
            'success' => true,
            'message' => 'Étape de démarchage client supprimée avec succès.',
        ]);
    }
}