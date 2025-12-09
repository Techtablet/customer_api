<?php

namespace App\Http\Requests\CustomerContactRoleRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerContactRoleRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom du rôle",
 *         example="Directeur"
 *     )
 * )
 */
class UpdateCustomerContactRoleRequest extends FormRequest
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
        $customerContactRoleId = $this->route('customer_contact_role');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('customer_contact_roles', 'name')->ignore($customerContactRoleId, 'id_contact_role'),
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
            'name.string' => 'Le nom du rôle doit être une chaîne de caractères.',
            'name.max' => 'Le nom du rôle ne peut pas dépasser :max caractères.',
            'name.unique' => 'Un rôle avec ce nom existe déjà.',
        ];
    }
}