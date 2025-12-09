<?php

namespace App\Http\Requests\StoreGroupRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreStoreGroupRequest",
 *     required={"group_name", "group_key", "first_name", "last_name"},
 *     @OA\Property(
 *         property="group_name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du groupe",
 *         example="Groupe Paris Centre"
 *     ),
 *     @OA\Property(
 *         property="group_key",
 *         type="string",
 *         maxLength=100,
 *         description="Clé unique du groupe",
 *         example="PARIS_CENTRE_01"
 *     ),
 *     @OA\Property(
 *         property="group_logo",
 *         type="string",
 *         maxLength=200,
 *         nullable=true,
 *         description="Logo du groupe",
 *         example="logos/paris-centre.png"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=200,
 *         description="Prénom du responsable",
 *         example="Jean"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du responsable",
 *         example="Dupont"
 *     ),
 *     @OA\Property(
 *         property="is_sepa",
 *         type="integer",
 *         description="Activation SEPA (0=non, 1=oui)",
 *         example=1
 *     )
 * )
 */
class StoreStoreGroupRequest extends FormRequest
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
            'group_name' => 'required|string|max:200',
            'group_key' => 'required|string|max:100|unique:store_groups,group_key',
            'group_logo' => 'nullable|string|max:200',
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'is_sepa' => 'required|integer|in:0,1',
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
            'group_name.required' => 'Le nom du groupe est obligatoire.',
            'group_name.string' => 'Le nom du groupe doit être une chaîne de caractères.',
            'group_name.max' => 'Le nom du groupe ne peut pas dépasser :max caractères.',
            'group_key.required' => 'La clé du groupe est obligatoire.',
            'group_key.string' => 'La clé du groupe doit être une chaîne de caractères.',
            'group_key.max' => 'La clé du groupe ne peut pas dépasser :max caractères.',
            'group_key.unique' => 'Un groupe avec cette clé existe déjà.',
            'group_logo.string' => 'Le logo doit être une chaîne de caractères.',
            'group_logo.max' => 'Le logo ne peut pas dépasser :max caractères.',
            'first_name.required' => 'Le prénom du responsable est obligatoire.',
            'first_name.string' => 'Le prénom du responsable doit être une chaîne de caractères.',
            'first_name.max' => 'Le prénom du responsable ne peut pas dépasser :max caractères.',
            'last_name.required' => 'Le nom du responsable est obligatoire.',
            'last_name.string' => 'Le nom du responsable doit être une chaîne de caractères.',
            'last_name.max' => 'Le nom du responsable ne peut pas dépasser :max caractères.',
            'is_sepa.required' => 'Le champ SEPA est obligatoire.',
            'is_sepa.integer' => 'Le champ SEPA doit être un entier.',
            'is_sepa.in' => 'Le champ SEPA doit être 0 ou 1.',
        ];
    }
}