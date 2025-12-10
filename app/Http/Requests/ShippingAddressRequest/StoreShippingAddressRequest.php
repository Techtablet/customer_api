<?php

namespace App\Http\Requests\ShippingAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreShippingAddressRequest",
 *     required={"id_customer_address", "id_customer"},
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
 *     @OA\Property(
 *         property="is_default",
 *         type="boolean",
 *         description="Indique si c'est l'adresse de livraison par défaut",
 *         example=true,
 *         nullable=true
 *     )
 * )
 */
class StoreShippingAddressRequest extends FormRequest
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
            'id_customer_address' => [
                'required',
                'integer',
                'exists:customer_addresses,id_customer_address',
            ],
            'id_customer' => [
                'required',
                'integer',
                'exists:customers,id_customer',
            ],
            'is_default' => [
                'nullable',
                'boolean',
                Rule::unique('shipping_addresses', 'is_default')->where(function ($query) {
                    return $query->where('is_default', true);
                }),
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
            'id_customer_address.required' => 'L\'ID de l\'adresse client est obligatoire.',
            'id_customer_address.exists' => 'L\'adresse client spécifiée n\'existe pas.',
            'id_customer.required' => 'L\'ID du client est obligatoire.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'is_default.unique' => 'Une adresse de livraison par défaut existe déjà.',
        ];
    }

    /**
     * Préparer les données pour validation.
     */
    protected function prepareForValidation()
    {
        // Si is_default est true, on s'assure qu'il n'y a pas déjà une adresse par défaut
        if ($this->is_default) {
            $this->merge([
                'is_default' => $this->checkDefaultAddress() ? false : true,
            ]);
        }
    }

    /**
     * Vérifier si une adresse par défaut existe déjà.
     *
     * @return bool
     */
    private function checkDefaultAddress(): bool
    {
        return \App\Models\ShippingAddress::where('is_default', true)->exists();
    }
}