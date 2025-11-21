<?php

namespace App\Http\Requests\CustomerContactTitleRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerContactTitleRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom de la civilité",
 *         example="Dr"
 *     )
 * )
 */
class UpdateCustomerContactTitleRequest extends FormRequest
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
        $customerContactTitleId = $this->route('customer_contact_title');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('customer_contact_titles', 'name')->ignore($customerContactTitleId, 'id_customer_contact_title'),
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
            'name.string' => 'Le nom de la civilité doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la civilité ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une civilité avec ce nom existe déjà.',
        ];
    }
}