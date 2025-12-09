<?php

namespace App\Http\Requests\ProfileRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateProfileRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom du profil",
 *         example="Administrateur"
 *     )
 * )
 */
class UpdateProfileRequest extends FormRequest
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
        $profileId = $this->route('profile');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('profiles', 'name')->ignore($profileId, 'id_profile'),
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
            'name.string' => 'Le nom du profil doit être une chaîne de caractères.',
            'name.max' => 'Le nom du profil ne peut pas dépasser :max caractères.',
            'name.unique' => 'Un profil avec ce nom existe déjà.',
        ];
    }
}