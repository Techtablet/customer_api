<?php

namespace App\Http\Requests\CustomerTypologyRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerTypologyRequest",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom de la typologie",
 *         example="Particulier"
 *     )
 * )
 */
class StoreCustomerTypologyRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:customer_typologies,name',
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
            'name.required' => 'Le nom de la typologie est obligatoire.',
            'name.string' => 'Le nom de la typologie doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la typologie ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une typologie avec ce nom existe déjà.',
        ];
    }
}