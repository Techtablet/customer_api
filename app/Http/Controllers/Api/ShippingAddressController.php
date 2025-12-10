<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingAddressRequest\StoreShippingAddressRequest;
use App\Http\Requests\ShippingAddressRequest\UpdateShippingAddressRequest;
use App\Models\ShippingAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="ShippingAddresses",
 *     description="Opérations CRUD pour les adresses de livraison"
 * )
 */
class ShippingAddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/shipping-addresses",
     *     summary="Liste toutes les adresses de livraison",
     *     tags={"ShippingAddresses"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des adresses de livraison récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/ShippingAddress")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des adresses de livraison récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $shippingAddresses = ShippingAddress::with(['customer', 'customerAddress'])->get();

        return response()->json([
            'success' => true,
            'data' => $shippingAddresses,
            'message' => 'Liste des adresses de livraison récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/shipping-addresses/{id}",
     *     summary="Affiche les détails d'une adresse de livraison spécifique",
     *     tags={"ShippingAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de livraison",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de livraison récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ShippingAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de livraison récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de livraison non trouvée"
     *     )
     * )
     */
    public function show(ShippingAddress $shippingAddress): JsonResponse
    {
        $shippingAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $shippingAddress,
            'message' => 'Adresse de livraison récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/shipping-addresses/customer/{customerId}",
     *     summary="Récupère les adresses de livraison d'un client spécifique",
     *     tags={"ShippingAddresses"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresses de livraison récupérées avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/ShippingAddress")
     *             ),
     *             @OA\Property(property="message", type="string", example="Adresses de livraison récupérées avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucune adresse de livraison trouvée pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $shippingAddresses = ShippingAddress::where('id_customer', $customerId)
            ->with(['customer', 'customerAddress'])
            ->get();

        if ($shippingAddresses->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune adresse de livraison trouvée pour ce client.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $shippingAddresses,
            'message' => 'Adresses de livraison récupérées avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/shipping-addresses/default",
     *     summary="Récupère l'adresse de livraison par défaut",
     *     tags={"ShippingAddresses"},
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de livraison par défaut récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ShippingAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de livraison par défaut récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucune adresse de livraison par défaut trouvée"
     *     )
     * )
     */
    public function showDefault(): JsonResponse
    {
        $shippingAddress = ShippingAddress::default()->with(['customer', 'customerAddress'])->first();

        if (!$shippingAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune adresse de livraison par défaut trouvée.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $shippingAddress,
            'message' => 'Adresse de livraison par défaut récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/shipping-addresses",
     *     summary="Crée une nouvelle adresse de livraison",
     *     tags={"ShippingAddresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreShippingAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Adresse de livraison créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ShippingAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de livraison créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreShippingAddressRequest $request): JsonResponse
    {
        $shippingAddress = ShippingAddress::create($request->validated());

        $shippingAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $shippingAddress,
            'message' => 'Adresse de livraison créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/shipping-addresses/{id}",
     *     summary="Met à jour une adresse de livraison existante",
     *     tags={"ShippingAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de livraison à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateShippingAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de livraison mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ShippingAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de livraison mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de livraison non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateShippingAddressRequest $request, ShippingAddress $shippingAddress): JsonResponse
    {
        // Si on veut définir cette adresse comme par défaut et qu'il y en a déjà une
        if ($request->has('is_default') && $request->is_default) {
            // Désactiver les autres adresses par défaut
            ShippingAddress::where('id_shipping_address', '!=', $shippingAddress->id_shipping_address)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $shippingAddress->update($request->validated());

        $shippingAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $shippingAddress,
            'message' => 'Adresse de livraison mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/shipping-addresses/{id}",
     *     summary="Supprime une adresse de livraison",
     *     tags={"ShippingAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de livraison à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de livraison supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Adresse de livraison supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de livraison non trouvée"
     *     )
     * )
     */
    public function destroy(ShippingAddress $shippingAddress): JsonResponse
    {
        // Si on supprime l'adresse par défaut, on pourrait vouloir définir une autre comme par défaut
        // Pour l'instant, on supprime simplement
        $shippingAddress->delete();

        return response()->json([
            'success' => true,
            'message' => 'Adresse de livraison supprimée avec succès.',
        ]);
    }
}