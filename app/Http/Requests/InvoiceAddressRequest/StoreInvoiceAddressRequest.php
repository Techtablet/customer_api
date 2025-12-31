<?php

namespace App\Http\Requests\InvoiceAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreInvoiceAddressRequest",
 *     required={"address_infos", "id_customer", "email"},
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email de l'adresse de facturation",
 *         example="contact@techcorp.com"
 *     ),
 *     @OA\Property(
 *         property="address_infos",
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/StoreCustomerAddressRequest"),
 *         },
 *         description="Informations de l'adresse de facturation du client"
 *     )
 * )
 */
class StoreInvoiceAddressRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_customer' => [
                'required',
                'integer',
                'unique:invoice_addresses,id_customer',
                'exists:customers,id_customer',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],

            // Règles pour l'adresse de facturation
            'address_infos' => 'required|array',
        ];
    }

    /**
     * Obtenir les messages d'erreur personnalisés pour les règles de validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            //'id_customer_address.required' => 'L\'ID de l\'adresse client est obligatoire.',
            //'id_customer_address.exists' => 'L\'adresse client spécifiée n\'existe pas.',
            'id_customer.required' => 'L\'ID du client est obligatoire.',
            'id_customer.unique' => 'Ce client a déjà une adresse de facturation.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'email.required' => 'L\'email de l\'adresse de facturation est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser :max caractères.',
            'address_infos.required' => 'Les informations address sont obligatoires.',
            'address_infos.array' => 'Les informations address doivent être un tableau.',
        ];
    }
}