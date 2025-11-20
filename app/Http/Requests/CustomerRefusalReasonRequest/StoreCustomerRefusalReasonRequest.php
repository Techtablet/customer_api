<?php

namespace App\Http\Requests\CustomerRefusalReasonRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerRefusalReasonRequest",
 *     required={"description"},
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description de la raison de refus",
 *         example="Le client n'a pas le budget nécessaire pour le projet"
 *     )
 * )
 */
class StoreCustomerRefusalReasonRequest extends FormRequest
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
            'description' => 'required|string|unique:customer_refusal_reasons,description',
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
            'description.required' => 'La description de la raison de refus est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.unique' => 'Une raison de refus avec cette description existe déjà.',
        ];
    }
}