<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerContactRequest\StoreCustomerContactRequest;
use App\Http\Requests\CustomerContactRequest\UpdateCustomerContactRequest;
use App\Models\CustomerContact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="CustomerContacts",
 *     description="Opérations CRUD pour les contacts clients"
 * )
 */
class CustomerContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer-contacts",
     *     summary="Liste tous les contacts clients",
     *     tags={"CustomerContacts"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des contacts clients récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContact")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des contacts clients récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $customerContacts = CustomerContact::with(['customer', 'contactTitle', 'contactRole'])->get();

        return response()->json([
            'success' => true,
            'data' => $customerContacts,
            'message' => 'Liste des contacts clients récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contacts/{id}",
     *     summary="Affiche les détails d'un contact client spécifique",
     *     tags={"CustomerContacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact client récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContact"),
     *             @OA\Property(property="message", type="string", example="Contact client récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact client non trouvé"
     *     )
     * )
     */
    public function show(CustomerContact $customerContact): JsonResponse
    {
        $customerContact->load(['customer', 'contactTitle', 'contactRole']);

        return response()->json([
            'success' => true,
            'data' => $customerContact,
            'message' => 'Contact client récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contacts/customer/{customerId}",
     *     summary="Récupère les contacts d'un client spécifique",
     *     tags={"CustomerContacts"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contacts client récupérés avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/CustomerContact")
     *             ),
     *             @OA\Property(property="message", type="string", example="Contacts client récupérés avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun contact trouvé pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $customerContacts = CustomerContact::where('id_customer', $customerId)
            ->with(['customer', 'contactTitle', 'contactRole'])
            ->get();

        if ($customerContacts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun contact trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $customerContacts,
            'message' => 'Contacts client récupérés avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customer-contacts/customer/{customerId}/default",
     *     summary="Récupère le contact par défaut d'un client",
     *     tags={"CustomerContacts"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact par défaut récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContact"),
     *             @OA\Property(property="message", type="string", example="Contact par défaut récupéré avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun contact par défaut trouvé pour ce client"
     *     )
     * )
     */
    public function showDefaultByCustomer($customerId): JsonResponse
    {
        $customerContact = CustomerContact::where('id_customer', $customerId)
            ->where('is_default', true)
            ->with(['customer', 'contactTitle', 'contactRole'])
            ->first();

        if (!$customerContact) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun contact par défaut trouvé pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $customerContact,
            'message' => 'Contact par défaut récupéré avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customer-contacts",
     *     summary="Crée un nouveau contact client",
     *     tags={"CustomerContacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCustomerContactRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContact"),
     *             @OA\Property(property="message", type="string", example="Contact client créé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreCustomerContactRequest $request): JsonResponse
    {
        $customerContact = CustomerContact::create($request->validated());

        $customerContact->load(['customer', 'contactTitle', 'contactRole']);

        return response()->json([
            'success' => true,
            'data' => $customerContact,
            'message' => 'Contact client créé avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/customer-contacts/{id}",
     *     summary="Met à jour un contact client existant",
     *     tags={"CustomerContacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact client à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCustomerContactRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact client mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerContact"),
     *             @OA\Property(property="message", type="string", example="Contact client mis à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateCustomerContactRequest $request, CustomerContact $customerContact): JsonResponse
    {
        // Si on veut définir ce contact comme par défaut
        if ($request->has('is_default') && $request->is_default && !$customerContact->is_default) {
            // Désactiver les autres contacts par défaut pour ce client
            CustomerContact::where('id_customer', $customerContact->id_customer)
                ->where('id_customer_contact', '!=', $customerContact->id_customer_contact)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $customerContact->update($request->validated());

        $customerContact->load(['customer', 'contactTitle', 'contactRole']);

        return response()->json([
            'success' => true,
            'data' => $customerContact,
            'message' => 'Contact client mis à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customer-contacts/{id}",
     *     summary="Supprime un contact client",
     *     tags={"CustomerContacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact client supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Contact client supprimé avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact client non trouvé"
     *     )
     * )
     */
    public function destroy(CustomerContact $customerContact): JsonResponse
    {
        // Si on supprime le contact par défaut
        if ($customerContact->is_default) {
            // On pourrait définir un autre contact comme par défaut
            // Pour l'instant, on supprime simplement
        }

        $customerContact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact client supprimé avec succès.',
        ]);
    }
}