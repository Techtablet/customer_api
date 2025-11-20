<?php

namespace App\Http\Requests\CustomerLocationRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerLocationRequest",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom de la localisation",
 *         example="Paris"
 *     )
 * )
 */
class StoreCustomerLocationRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:customer_locations,name',
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
            'name.required' => 'Le nom de la localisation est obligatoire.',
            'name.string' => 'Le nom de la localisation doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la localisation ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une localisation avec ce nom existe déjà.',
        ];
    }
}