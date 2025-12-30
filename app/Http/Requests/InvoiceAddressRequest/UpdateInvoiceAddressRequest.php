<?php

namespace App\Http\Requests\InvoiceAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateInvoiceAddressRequest",
 *     @OA\Property(
 *         property="id_customer_address",
 *         type="integer",
 *         description="ID de l'adresse client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *    @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email de l'adresse de facturation",
 *         example="contact@techcorp.com"
 *     )
 * )
 */
class UpdateInvoiceAddressRequest extends FormRequest
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
        $invoiceAddressId = $this->route('invoice_address');

        return [
            'id_customer_address' => [
                'sometimes',
                'integer',
                'exists:customer_addresses,id_customer_address',
            ],
            'id_customer' => [
                'sometimes',
                'integer',
                Rule::unique('invoice_addresses', 'id_customer')->ignore($invoiceAddressId, 'id_invoice_address'),
                'exists:customers,id_customer',
            ],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
            ],
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
            'id_customer_address.exists' => 'L\'adresse client spécifiée n\'existe pas.',
            'id_customer.unique' => 'Ce client a déjà une adresse de facturation.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser :max caractères.',
        ];
    }
}