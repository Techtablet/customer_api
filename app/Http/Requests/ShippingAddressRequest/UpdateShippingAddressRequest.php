<?php

namespace App\Http\Requests\ShippingAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateShippingAddressRequest",
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
class UpdateShippingAddressRequest extends FormRequest
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
        $shippingAddressId = $this->route('shipping_address');

        return [
            'id_customer_address' => [
                'sometimes',
                'integer',
                'exists:customer_addresses,id_customer_address',
            ],
            'id_customer' => [
                'sometimes',
                'integer',
                'exists:customers,id_customer',
            ],
            'is_default' => [
                'nullable',
                'boolean',
                Rule::unique('shipping_addresses', 'is_default')
                    ->where(function ($query) {
                        return $query->where('is_default', true);
                    })
                    ->ignore($shippingAddressId, 'id_shipping_address'),
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
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'is_default.unique' => 'Une adresse de livraison par défaut existe déjà.',
        ];
    }

    /**
     * Préparer les données pour validation.
     */
    protected function prepareForValidation()
    {
        // Si is_default est true, on ignore la validation unique si c'est cette adresse qui est déjà par défaut
        if ($this->is_default) {
            $shippingAddressId = $this->route('shipping_address');
            $currentShippingAddress = \App\Models\ShippingAddress::find($shippingAddressId);
            
            if ($currentShippingAddress && $currentShippingAddress->is_default) {
                // Cette adresse est déjà par défaut, on ne change rien
                $this->merge([
                    'is_default' => true,
                ]);
            } else {
                // On vérifie s'il y a déjà une adresse par défaut
                $hasDefault = \App\Models\ShippingAddress::where('is_default', true)
                    ->where('id_shipping_address', '!=', $shippingAddressId)
                    ->exists();
                
                if ($hasDefault) {
                    $this->merge([
                        'is_default' => false,
                    ]);
                }
            }
        }
    }
}