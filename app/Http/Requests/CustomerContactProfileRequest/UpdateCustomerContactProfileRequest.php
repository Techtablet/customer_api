<?php

namespace App\Http\Requests\CustomerContactProfileRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerContactProfileRequest",
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
class UpdateCustomerContactProfileRequest extends FormRequest
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
        $customerContactProfileId = $this->route('customer_contact_profile');

        return [
            'id_profile' => [
                'sometimes',
                'integer',
                'exists:profiles,id_profile',
            ],
            'id_contact' => [
                'sometimes',
                'integer',
                'exists:customer_contacts,id_customer_contact',
                Rule::unique('customer_contact_profiles')->where(function ($query) use ($customerContactProfileId) {
                    $query = $query->where('id_profile', $this->id_profile ?? $this->customer_contact_profile->id_profile);
                    if ($customerContactProfileId) {
                        $query = $query->where('id_contact_profile', '!=', $customerContactProfileId);
                    }
                    return $query;
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
            'id_profile.exists' => 'Le profil spécifié n\'existe pas.',
            'id_contact.exists' => 'Le contact client spécifié n\'existe pas.',
            'id_contact.unique' => 'Ce contact est déjà associé à ce profil.',
        ];
    }
}