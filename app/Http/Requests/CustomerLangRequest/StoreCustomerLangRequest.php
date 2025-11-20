<?php

namespace App\Http\Requests\CustomerLangRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerLangRequest",
 *     required={"name", "code_iso"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=250,
 *         description="Nom de la langue",
 *         example="Français"
 *     ),
 *     @OA\Property(
 *         property="code_iso",
 *         type="string",
 *         maxLength=10,
 *         description="Code ISO de la langue",
 *         example="fr"
 *     )
 * )
 */
class StoreCustomerLangRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:customer_langs,name',
            'code_iso' => 'required|string|max:10|unique:customer_langs,code_iso',
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
            'name.required' => 'Le nom de la langue est obligatoire.',
            'name.string' => 'Le nom de la langue doit être une chaîne de caractères.',
            'name.max' => 'Le nom de la langue ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une langue avec ce nom existe déjà.',
            'code_iso.required' => 'Le code ISO est obligatoire.',
            'code_iso.string' => 'Le code ISO doit être une chaîne de caractères.',
            'code_iso.max' => 'Le code ISO ne peut pas dépasser :max caractères.',
            'code_iso.unique' => 'Une langue avec ce code ISO existe déjà.',
        ];
    }
}