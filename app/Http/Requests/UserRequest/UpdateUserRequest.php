<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"admin", "customer"},
 *         description="Type de l'utilisateur",
 *         example="admin"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Adresse email",
 *         example="admin@example.com"
 *     ),
 *    @OA\Property(
 *         property="user_key",
 *         type="string",
 *         description="Clé utilisateur",
 *         example="KTG23T45"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Mot de passe",
 *         example="NewSecret123!"
 *     )
 * )
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // À modifier selon votre logique d'autorisation
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'type' => 'sometimes|string|in:admin,customer',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId, 'id_user'),
            ],
            'user_key' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'user_key')->ignore($userId, 'id_user'),
            ],
            'password' => ['sometimes', 'string', Password::defaults()],
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
            'type.in' => 'Le type doit être "admin" ou "customer".',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser :max caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'user_key.max' => 'La clé utilisateur ne peut pas dépasser :max caractères.',
            'user_key.unique' => 'Cette clé utilisateur est déjà utilisée.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ];
    }
}