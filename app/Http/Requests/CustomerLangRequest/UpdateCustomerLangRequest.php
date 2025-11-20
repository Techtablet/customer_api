<?php

namespace App\Http\Requests\CustomerLangRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerLangRequest",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=250,
 *         description="Nom de la langue",
 *         example="Français Modifié"
 *     ),
 *     @OA\Property(
 *         property="code_iso",
 *         type="string",
 *         maxLength=10,
 *         description="Code ISO de la langue",
 *         example="fr-FR"
 *     )
 * )
 */
class UpdateCustomerLangRequest extends FormRequest
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
        $customerLangId = $this->route('customer_lang');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:250',
                Rule::unique('customer_langs', 'name')->ignore($customerLangId, 'id_customer_lang'),
            ],
            'code_iso' => [
                'sometimes',
                'string',
                'max:10',
                Rule::unique('customer_langs', 'code_iso')->ignore($customerLangId, 'id_customer_lang'),
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
            'name.string' => 'Le nom de la langue doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la langue ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une langue avec ce nom existe déjà.',
            'code_iso.string' => 'Le code ISO doit être une chaîne de caractères.',
            'code_iso.max' => 'Le code ISO ne peut pas dépasser :max caractères.',
            'code_iso.unique' => 'Une langue avec ce code ISO existe déjà.',
        ];
    }
}