<?php

namespace App\Http\Requests\CrmCustomersTagRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreCrmCustomersTagRequest",
 *     required={"id_crm_tag", "id_customer"},
 *     @OA\Property(
 *         property="id_crm_tag",
 *         type="integer",
 *         description="ID du tag CRM",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     )
 * )
 */
class StoreCrmCustomersTagRequest extends FormRequest
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
            'id_crm_tag' => [
                'required',
                'integer',
                'exists:crm_tags,id_crm_tag',
                Rule::unique('crm_customers_tags')->where(function ($query) {
                    return $query->where('id_customer', $this->id_customer);
                }),
            ],
            'id_customer' => [
                'required',
                'integer',
                'exists:customers,id_customer',
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
            'id_crm_tag.required' => 'L\'ID du tag CRM est obligatoire.',
            'id_crm_tag.exists' => 'Le tag CRM spécifié n\'existe pas.',
            'id_crm_tag.unique' => 'Ce tag est déjà associé à ce client.',
            'id_customer.required' => 'L\'ID du client est obligatoire.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
        ];
    }
}