<?php

namespace App\Http\Requests\CrmCallsStatusRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCrmCallsStatusRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="Nom du statut",
 *         example="Réussi"
 *     )
 * )
 */
class UpdateCrmCallsStatusRequest extends FormRequest
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
        $crmCallsStatusId = $this->route('crm_calls_status');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('crm_calls_statuses', 'name')->ignore($crmCallsStatusId, 'id_crm_calls_status'),
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
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'name.unique' => 'Un statut avec ce nom existe déjà.',
        ];
    }
}