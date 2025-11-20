<?php

namespace App\Http\Requests\CustomerLocationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerLocationRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom de la localisation",
 *         example="Lyon"
 *     )
 * )
 */
class UpdateCustomerLocationRequest extends FormRequest
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
        $customerLocationId = $this->route('customer_location');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('customer_locations', 'name')->ignore($customerLocationId, 'id_customer_location'),
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
            'name.string' => 'Le nom de la localisation doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la localisation ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une localisation avec ce nom existe déjà.',
        ];
    }
}