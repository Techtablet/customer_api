<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerScheduleRequest\StoreCustomerScheduleRequest;
use App\Http\Requests\CustomerScheduleRequest\UpdateCustomerScheduleRequest;
use App\Models\CustomerSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerSchedules",
 *     description="Opérations CRUD pour les horaires clients"
 * )
 */
class CustomerScheduleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-schedules",
     *     summary="Liste tous les horaires clients",
     *     tags={"CustomerSchedules"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des horaires clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerSchedule")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des horaires clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerSchedules = CustomerSchedule::with('customer')->get();

        return response()->json([
            'success' => true,
            'data' => $customerSchedules,
            'message' => 'Liste des horaires clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-schedules/{id}",
     *     summary="Affiche les détails d'un horaire client spécifique",
     *     tags={"CustomerSchedules"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'horaire client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horaire client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerSchedule"),
     *             @OA\Property(property="message", type="string", example="Horaire client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horaire client non trouvé"
     *     )
     * )
     */
    public function show(CustomerSchedule $customerSchedule): JsonResponse
    {
        $customerSchedule->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerSchedule,
            'message' => 'Horaire client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-schedules/customer/{customerId}",
     *     summary="Récupère les horaires d'un client spécifique",
     *     tags={"CustomerSchedules"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horaires client récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerSchedule")
     *             ),
     *             @OA\Property(property="message", type="string", example="Horaires client récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun horaire trouvé pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $customerSchedules = CustomerSchedule::where('id_customer', $customerId)
            ->with('customer')
            ->get();

        if ($customerSchedules->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun horaire trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $customerSchedules,
            'message' => 'Horaires client récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-schedules/day/{day}",
     *     summary="Récupère les horaires pour un jour spécifique",
     *     tags={"CustomerSchedules"},
     *     @OA\Parameter(
     *         name="day",
     *         in="path",
     *         required=true,
     *         description="Jour (1=lundi, 7=dimanche)",
     *         @OA\Schema(type="integer", minimum=1, maximum=7)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horaires du jour récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerSchedule")
     *             ),
     *             @OA\Property(property="message", type="string", example="Horaires du jour récupérés avec succès.")
     *         )
     *     )
     * )
     */
    public function showByDay($day): JsonResponse
    {
        $customerSchedules = CustomerSchedule::forDay($day)
            ->with('customer')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customerSchedules,
            'message' => 'Horaires du jour récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-schedules/currently-open",
     *     summary="Récupère les clients actuellement ouverts",
     *     tags={"CustomerSchedules"},
     *     @OA\Response(
     *         response=200,
     *         description="Clients ouverts récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerSchedule")
     *             ),
     *             @OA\Property(property="message", type="string", example="Clients ouverts récupérés avec succès.")
     *         )
     *     )
     * )
     */
    public function showCurrentlyOpen(): JsonResponse
    {
        $customerSchedules = CustomerSchedule::currentlyOpen()
            ->with('customer')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customerSchedules,
            'message' => 'Clients ouverts récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-schedules",
     *     summary="Crée un nouvel horaire client",
     *     tags={"CustomerSchedules"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerScheduleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Horaire client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerSchedule"),
     *             @OA\Property(property="message", type="string", example="Horaire client créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerScheduleRequest $request): JsonResponse
    {
        $customerSchedule = CustomerSchedule::create($request->validated());

        $customerSchedule->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerSchedule,
            'message' => 'Horaire client créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-schedules/{id}",
     *     summary="Met à jour un horaire client existant",
     *     tags={"CustomerSchedules"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'horaire client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerScheduleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horaire client mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerSchedule"),
     *             @OA\Property(property="message", type="string", example="Horaire client mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horaire client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerScheduleRequest $request, CustomerSchedule $customerSchedule): JsonResponse
    {
        $customerSchedule->update($request->validated());

        $customerSchedule->load('customer');

        return response()->json([
            'success' => true,
            'data' => $customerSchedule,
            'message' => 'Horaire client mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-schedules/{id}",
     *     summary="Supprime un horaire client",
     *     tags={"CustomerSchedules"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'horaire client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Horaire client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Horaire client supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Horaire client non trouvé"
     *     )
     * )
     */
    public function destroy(CustomerSchedule $customerSchedule): JsonResponse
    {
        $customerSchedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Horaire client supprimé avec succès.',
        ]);
    }
}