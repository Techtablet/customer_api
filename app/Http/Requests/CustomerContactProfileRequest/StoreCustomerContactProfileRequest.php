<?php

namespace App\Http\Requests\CustomerContactProfileRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreCustomerContactProfileRequest",
 *     required={"id_profile", "id_contact"},
 *     @OA\Property(
 *         property="id_profile",
 *         type="integer",
 *         description="ID du profil",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_contact",
 *         type="integer",
 *         description="ID du contact client",
 *         example=1
 *     )
 * )
 */
class StoreCustomerContactProfileRequest extends FormRequest
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
            'id_profile' => [
                'required',
                'integer',
                'exists:profiles,id_profile',
            ],
            'id_contact' => [
                'required',
                'integer',
                'exists:customer_contacts,id_customer_contact',
                Rule::unique('customer_contact_profiles')->where(function ($query) {
                    return $query->where('id_profile', $this->id_profile);
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
            'id_profile.required' => 'L\'ID du profil est obligatoire.',
            'id_profile.exists' => 'Le profil spécifié n\'existe pas.',
            'id_contact.required' => 'L\'ID du contact client est obligatoire.',
            'id_contact.exists' => 'Le contact client spécifié n\'existe pas.',
            'id_contact.unique' => 'Ce contact est déjà associé à ce profil.',
        ];
    }
}