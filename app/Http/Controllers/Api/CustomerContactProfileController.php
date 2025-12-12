<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerContactProfileRequest\StoreCustomerContactProfileRequest;
use App\Http\Requests\CustomerContactProfileRequest\UpdateCustomerContactProfileRequest;
use App\Models\CustomerContactProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerContactProfiles",
 *     description="Opérations CRUD pour les liaisons entre profils et contacts clients"
 * )
 */
class CustomerContactProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-contact-profiles",
     *     summary="Liste toutes les liaisons profils-contacts",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des liaisons récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContactProfile")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des liaisons profils-contacts récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerContactProfiles = CustomerContactProfile::with(['profile', 'customerContact'])->get();

        return response()->json([
            'success' => true,
            'data' => $customerContactProfiles,
            'message' => 'Liste des liaisons profils-contacts récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contact-profiles/{id}",
     *     summary="Affiche les détails d'une liaison spécifique",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactProfile"),
     *             @OA\Property(property="message", type="string", example="Liaison profils-contacts récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     )
     * )
     */
    public function show(CustomerContactProfile $customerContactProfile): JsonResponse
    {
        $customerContactProfile->load(['profile', 'customerContact']);

        return response()->json([
            'success' => true,
            'data' => $customerContactProfile,
            'message' => 'Liaison profils-contacts récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contact-profiles/profile/{profileId}",
     *     summary="Récupère les liaisons pour un profil spécifique",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Parameter(
     *         name="profileId",
     *         in="path",
     *         required=true,
     *         description="ID du profil",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaisons du profil récupérées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContactProfile")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liaisons du profil récupérées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucune liaison trouvée pour ce profil"
     *     )
     * )
     */
    public function showByProfile($profileId): JsonResponse
    {
        $customerContactProfiles = CustomerContactProfile::where('id_profile', $profileId)
            ->with(['profile', 'customerContact'])
            ->get();

        if ($customerContactProfiles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune liaison trouvée pour ce profil.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $customerContactProfiles,
            'message' => 'Liaisons du profil récupérées avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contact-profiles/contact/{contactId}",
     *     summary="Récupère les liaisons pour un contact spécifique",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Parameter(
     *         name="contactId",
     *         in="path",
     *         required=true,
     *         description="ID du contact client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaisons du contact récupérées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContactProfile")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liaisons du contact récupérées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucune liaison trouvée pour ce contact"
     *     )
     * )
     */
    public function showByContact($contactId): JsonResponse
    {
        $customerContactProfiles = CustomerContactProfile::where('id_contact', $contactId)
            ->with(['profile', 'customerContact'])
            ->get();

        if ($customerContactProfiles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune liaison trouvée pour ce contact.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $customerContactProfiles,
            'message' => 'Liaisons du contact récupérées avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-contact-profiles",
     *     summary="Crée une nouvelle liaison profil-contact",
     *     tags={"CustomerContactProfiles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerContactProfileRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Liaison créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactProfile"),
     *             @OA\Property(property="message", type="string", example="Liaison profil-contact créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerContactProfileRequest $request): JsonResponse
    {
        $customerContactProfile = CustomerContactProfile::create($request->validated());

        $customerContactProfile->load(['profile', 'customerContact']);

        return response()->json([
            'success' => true,
            'data' => $customerContactProfile,
            'message' => 'Liaison profil-contact créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-contact-profiles/{id}",
     *     summary="Met à jour une liaison existante",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerContactProfileRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContactProfile"),
     *             @OA\Property(property="message", type="string", example="Liaison profil-contact mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerContactProfileRequest $request, CustomerContactProfile $customerContactProfile): JsonResponse
    {
        $customerContactProfile->update($request->validated());

        $customerContactProfile->load(['profile', 'customerContact']);

        return response()->json([
            'success' => true,
            'data' => $customerContactProfile,
            'message' => 'Liaison profil-contact mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-contact-profiles/{id}",
     *     summary="Supprime une liaison",
     *     tags={"CustomerContactProfiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la liaison à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liaison supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liaison profil-contact supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liaison non trouvée"
     *     )
     * )
     */
    public function destroy(CustomerContactProfile $customerContactProfile): JsonResponse
    {
        $customerContactProfile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Liaison profil-contact supprimée avec succès.',
        ]);
    }
}