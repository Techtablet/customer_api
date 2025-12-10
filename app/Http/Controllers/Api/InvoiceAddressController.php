<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceAddressRequest\StoreInvoiceAddressRequest;
use App\Http\Requests\InvoiceAddressRequest\UpdateInvoiceAddressRequest;
use App\Models\InvoiceAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="InvoiceAddresses",
 *     description="Opérations CRUD pour les adresses de facturation"
 * )
 */
class InvoiceAddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/invoice-addresses",
     *     summary="Liste toutes les adresses de facturation",
     *     tags={"InvoiceAddresses"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des adresses de facturation récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/InvoiceAddress")
     *             ),
     *             @OA\Property(property="message", type="string", example="Liste des adresses de facturation récupérée avec succès.")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $invoiceAddresses = InvoiceAddress::with(['customer', 'customerAddress'])->get();

        return response()->json([
            'success' => true,
            'data' => $invoiceAddresses,
            'message' => 'Liste des adresses de facturation récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/invoice-addresses/{id}",
     *     summary="Affiche les détails d'une adresse de facturation spécifique",
     *     tags={"InvoiceAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de facturation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de facturation récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/InvoiceAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de facturation récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de facturation non trouvée"
     *     )
     * )
     */
    public function show(InvoiceAddress $invoiceAddress): JsonResponse
    {
        $invoiceAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $invoiceAddress,
            'message' => 'Adresse de facturation récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/invoice-addresses/customer/{customerId}",
     *     summary="Récupère l'adresse de facturation d'un client spécifique",
     *     tags={"InvoiceAddresses"},
     *     @OA\Parameter(
     *         name="customerId",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de facturation récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/InvoiceAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de facturation récupérée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de facturation non trouvée pour ce client"
     *     )
     * )
     */
    public function showByCustomer($customerId): JsonResponse
    {
        $invoiceAddress = InvoiceAddress::where('id_customer', $customerId)
            ->with(['customer', 'customerAddress'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $invoiceAddress,
            'message' => 'Adresse de facturation récupérée avec succès.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/invoice-addresses",
     *     summary="Crée une nouvelle adresse de facturation",
     *     tags={"InvoiceAddresses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreInvoiceAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Adresse de facturation créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/InvoiceAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de facturation créée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store(StoreInvoiceAddressRequest $request): JsonResponse
    {
        $invoiceAddress = InvoiceAddress::create($request->validated());

        $invoiceAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $invoiceAddress,
            'message' => 'Adresse de facturation créée avec succès.',
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/invoice-addresses/{id}",
     *     summary="Met à jour une adresse de facturation existante",
     *     tags={"InvoiceAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de facturation à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateInvoiceAddressRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de facturation mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/InvoiceAddress"),
     *             @OA\Property(property="message", type="string", example="Adresse de facturation mise à jour avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de facturation non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(UpdateInvoiceAddressRequest $request, InvoiceAddress $invoiceAddress): JsonResponse
    {
        $invoiceAddress->update($request->validated());

        $invoiceAddress->load(['customer', 'customerAddress']);

        return response()->json([
            'success' => true,
            'data' => $invoiceAddress,
            'message' => 'Adresse de facturation mise à jour avec succès.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/invoice-addresses/{id}",
     *     summary="Supprime une adresse de facturation",
     *     tags={"InvoiceAddresses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'adresse de facturation à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Adresse de facturation supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Adresse de facturation supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Adresse de facturation non trouvée"
     *     )
     * )
     */
    public function destroy(InvoiceAddress $invoiceAddress): JsonResponse
    {
        $invoiceAddress->delete();

        return response()->json([
            'success' => true,
            'message' => 'Adresse de facturation supprimée avec succès.',
        ]);
    }
}