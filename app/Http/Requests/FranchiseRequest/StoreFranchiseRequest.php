<?php

namespace App\Http\Requests\FranchiseRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreFranchiseRequest",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=30,
 *         description="Nom de la franchise",
 *         example="Ma Nouvelle Franchise"
 *     )
 * )
 */
class StoreFranchiseRequest extends FormRequest
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
            'name' => 'required|string|max:30|unique:franchises,name',
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
            'name.required' => 'Le nom de la franchise est obligatoire.',
            'name.string' => 'Le nom de la franchise doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la franchise ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une franchise avec ce nom existe déjà.',
        ];
    }
}