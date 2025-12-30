<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     required={"type", "email", "password"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"admin", "customer"},
 *         description="Type de l'utilisateur",
 *         example="customer"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Adresse email",
 *         example="user@example.com"
 *     ),
 *     @OA\Property(
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
 *         example="Secret123!"
 *     )
 * )
 */
class StoreUserRequest extends FormRequest
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
        return [
            'type' => 'required|string|in:admin,customer',
            'email' => 'required|string|email|max:255|unique:users,email',
            'user_key' => 'required|string|max:255|unique:users,user_key',
            'password' => ['required', 'string', Password::defaults()],
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
            'type.required' => 'Le type d\'utilisateur est obligatoire.',
            'type.in' => 'Le type doit être "admin" ou "customer".',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser :max caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'user_key.required' => 'La clé utilisateur est obligatoire.',
            'user_key.max' => 'La clé utilisateur ne peut pas dépasser :max caractères.',
            'user_key.unique' => 'Cette clé utilisateur est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ];
    }
}