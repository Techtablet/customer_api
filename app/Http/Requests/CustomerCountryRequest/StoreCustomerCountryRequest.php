<?php

namespace App\Http\Requests\CustomerCountryRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerCountryRequest",
 *     required={"name", "name_en", "name_de", "isocode"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du pays en français",
 *         example="France"
 *     ),
 *     @OA\Property(
 *         property="name_en",
 *         type="string",
 *         maxLength=70,
 *         description="Nom du pays en anglais",
 *         example="France"
 *     ),
 *     @OA\Property(
 *         property="name_de",
 *         type="string",
 *         maxLength=70,
 *         description="Nom du pays en allemand",
 *         example="Frankreich"
 *     ),
 *     @OA\Property(
 *         property="isocode",
 *         type="string",
 *         maxLength=5,
 *         description="Code ISO du pays",
 *         example="FR"
 *     ),
 *     @OA\Property(
 *         property="ccn3",
 *         type="integer",
 *         nullable=true,
 *         description="Code numérique du pays",
 *         example=250
 *     ),
 *     @OA\Property(
 *         property="phone_code",
 *         type="string",
 *         maxLength=10,
 *         nullable=true,
 *         description="Indicatif téléphonique",
 *         example="+33"
 *     ),
 *     @OA\Property(
 *         property="is_intracom_vat",
 *         type="integer",
 *         description="Pays intracommunautaire pour TVA (0=non, 1=oui)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="is_ue_export",
 *         type="integer",
 *         description="Pays UE pour export (0=non, 1=oui)",
 *         example=1
 *     )
 * )
 */
class StoreCustomerCountryRequest extends FormRequest
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
            'name' => 'required|string|max:200|unique:customer_countries,name',
            'name_en' => 'required|string|max:70',
            'name_de' => 'required|string|max:70',
            'isocode' => 'required|string|max:5|unique:customer_countries,isocode',
            'ccn3' => 'nullable|integer',
            'phone_code' => 'nullable|string|max:10',
            'is_intracom_vat' => 'required|integer|in:0,1',
            'is_ue_export' => 'required|integer|in:0,1',
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
            'name.required' => 'Le nom du pays en français est obligatoire.',
            'name.string' => 'Le nom du pays en français doit être une chaîne de caractères.',
            'name.max' => 'Le nom du pays en français ne peut pas dépasser :max caractères.',
            'name.unique' => 'Un pays avec ce nom français existe déjà.',
            'name_en.required' => 'Le nom du pays en anglais est obligatoire.',
            'name_en.string' => 'Le nom du pays en anglais doit être une chaîne de caractères.',
            'name_en.max' => 'Le nom du pays en anglais ne peut pas dépasser :max caractères.',
            'name_de.required' => 'Le nom du pays en allemand est obligatoire.',
            'name_de.string' => 'Le nom du pays en allemand doit être une chaîne de caractères.',
            'name_de.max' => 'Le nom du pays en allemand ne peut pas dépasser :max caractères.',
            'isocode.required' => 'Le code ISO est obligatoire.',
            'isocode.string' => 'Le code ISO doit être une chaîne de caractères.',
            'isocode.max' => 'Le code ISO ne peut pas dépasser :max caractères.',
            'isocode.unique' => 'Un pays avec ce code ISO existe déjà.',
            'ccn3.integer' => 'Le code numérique doit être un entier.',
            'phone_code.string' => 'L\'indicatif téléphonique doit être une chaîne de caractères.',
            'phone_code.max' => 'L\'indicatif téléphonique ne peut pas dépasser :max caractères.',
            'is_intracom_vat.required' => 'Le champ pays intracommunautaire TVA est obligatoire.',
            'is_intracom_vat.integer' => 'Le champ pays intracommunautaire TVA doit être un entier.',
            'is_intracom_vat.in' => 'Le champ pays intracommunautaire TVA doit être 0 ou 1.',
            'is_ue_export.required' => 'Le champ pays UE export est obligatoire.',
            'is_ue_export.integer' => 'Le champ pays UE export doit être un entier.',
            'is_ue_export.in' => 'Le champ pays UE export doit être 0 ou 1.',
        ];
    }
}