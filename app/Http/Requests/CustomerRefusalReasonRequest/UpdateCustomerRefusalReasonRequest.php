<?php

namespace App\Http\Requests\CustomerRefusalReasonRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerRefusalReasonRequest",
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description de la raison de refus",
 *         example="Le projet ne correspond pas aux besoins actuels du client"
 *     )
 * )
 */
class UpdateCustomerRefusalReasonRequest extends FormRequest
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
        $customerRefusalReasonId = $this->route('customer_refusal_reason');

        return [
            'description' => [
                'sometimes',
                'string',
                Rule::unique('customer_refusal_reasons', 'description')->ignore($customerRefusalReasonId, 'id_customer_refusal_reason'),
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
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.unique' => 'Une raison de refus avec cette description existe déjà.',
        ];
    }
}