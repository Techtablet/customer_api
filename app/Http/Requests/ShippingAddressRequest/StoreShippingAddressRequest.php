<?php

namespace App\Http\Requests\ShippingAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreShippingAddressRequest",
 *     required={"id_customer", "address_name", "address_infos"},
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
 *     ),
 *     @OA\Property(
 *         property="address_name",
 *         type="string",
 *         maxLength=64,
 *         nullable=true,
 *         description="Nom personnalisé de l'adresse",
 *         example="Domicile"
 *     ),
 *     @OA\Property(
 *         property="has_difficult_access",
 *         type="boolean",
 *         description="Accès difficile",
 *         example=false
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
            'id_customer' => [
                'required',
                'integer',
                'exists:customers,id_customer',
            ],
            'is_default' => [
                'nullable',
                'boolean',
                Rule::unique('shipping_addresses')
                    ->where(function ($query) {
                        return $query
                            ->where('is_default', true)
                            ->where('id_customer', $this->id_customer);
                    })
                    ->ignore($this->route('id_shipping_address'), 'id_shipping_address'),
            ],
            'address_name' => 'required|string|max:100',
            'has_difficult_access' => 'boolean',

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
            'id_customer.required' => 'L\'ID du client est obligatoire.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'is_default.unique' => 'Ce client a déjà une adresse de livraison par défaut.',
            'address_name.required' => 'Le nom d\'adresse est obligatoire.',
            'address_name.string' => 'Le nom d\'adresse doit être une chaîne de caractères.',
            'address_name.max' => 'Le nom d\'adresse ne peut pas dépasser :max caractères.',
            'has_difficult_access.boolean' => 'Le champ accès difficile doit être vrai ou faux.',
            'address_infos.required' => 'Les informations address sont obligatoires.',
            'address_infos.array' => 'Les informations address doivent être un tableau.',
        ];
    }

    /**
     * Préparer les données pour validation.
     */
    protected function prepareForValidation()
    {
        // Si is_default est true et qu'une adresse par défaut existe déjà pour ce client,
        // on définit is_default à false
        if ($this->is_default && $this->id_customer) {
            $this->merge([
                'is_default' => $this->hasExistingDefaultAddress() ? false : true,
            ]);
        }
    }

    /**
     * Vérifier si une adresse par défaut existe déjà pour ce client.
     *
     * @return bool
     */
    private function hasExistingDefaultAddress(): bool
    {
        return \App\Models\ShippingAddress::where('is_default', true)
            ->where('id_customer', $this->id_customer)
            ->exists();
    }
}