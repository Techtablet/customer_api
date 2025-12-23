<?php

namespace App\Http\Requests\TechtabletSellerRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreTechtabletSellerRequest",
 *     required={"first_name", "employee_code"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=50,
 *         description="Prénom",
 *         example="Pierre"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=50,
 *         nullable=true,
 *         description="Nom",
 *         example="Martin"
 *     ),
 *     @OA\Property(
 *         property="phone1",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Téléphone principal",
 *         example="+33123456789"
 *     ),
 *     @OA\Property(
 *         property="phone2",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Téléphone secondaire",
 *         example="+33612345678"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         maxLength=150,
 *         nullable=true,
 *         description="Email professionnel",
 *         example="pierre.martin@techtablet.com"
 *     ),
 *     @OA\Property(
 *         property="post",
 *         type="string",
 *         maxLength=100,
 *         nullable=true,
 *         description="Poste/emploi occupé",
 *         example="Commercial Senior"
 *     ),
 *     @OA\Property(
 *         property="key",
 *         type="string",
 *         maxLength=30,
 *         description="Code employé unique",
 *         example="EMP001"
 *     ),
 *     @OA\Property(
 *         property="signature",
 *         type="string",
 *         nullable=true,
 *         description="Signature numérique",
 *         example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA..."
 *     ),
 *     @OA\Property(
 *         property="is_active",
 *         type="boolean",
 *         description="Statut actif",
 *         example=true
 *     )
 * )
 */
class StoreTechtabletSellerRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'phone1' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            //'email' => 'nullable|email|max:150|unique:techtablet_sellers,email',
            'email' => 'nullable|email|max:150',
            'post' => 'nullable|string|max:100',
            'key' => 'required|string|max:30|unique:techtablet_sellers,key',
            'key' => 'required|string|max:30|unique:techtablet_sellers,key',
            'signature' => 'nullable|string',
            'is_active' => 'boolean',
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
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.max' => 'Le prénom ne peut pas dépasser :max caractères.',
            'last_name.string' => 'Le nom doit être une chaîne de caractères.',
            'last_name.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'phone1.string' => 'Le téléphone principal doit être une chaîne de caractères.',
            'phone1.max' => 'Le téléphone principal ne peut pas dépasser :max caractères.',
            'phone2.string' => 'Le téléphone secondaire doit être une chaîne de caractères.',
            'phone2.max' => 'Le téléphone secondaire ne peut pas dépasser :max caractères.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser :max caractères.',
            //'email.unique' => 'Un vendeur avec cet email existe déjà.',
            'post.string' => 'Le poste doit être une chaîne de caractères.',
            'post.max' => 'Le poste ne peut pas dépasser :max caractères.',
            'key.required' => 'Le code employé est obligatoire.',
            'key.string' => 'Le code employé doit être une chaîne de caractères.',
            'key.max' => 'Le code employé ne peut pas dépasser :max caractères.',
            //'key.unique' => 'Un vendeur avec ce code employé existe déjà.',
            'signature.string' => 'La signature numérique doit être une chaîne de caractères.',
            'is_active.boolean' => 'Le statut actif doit être vrai ou faux.',
        ];
    }
}