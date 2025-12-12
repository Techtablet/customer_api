<?php

namespace App\Http\Requests\CrmTagRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCrmTagRequest",
 *     required={"description"},
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description du tag",
 *         example="Client important"
 *     ),
 *     @OA\Property(
 *         property="inactive",
 *         type="boolean",
 *         description="Indique si le tag est inactif",
 *         example=false
 *     )
 * )
 */
class StoreCrmTagRequest extends FormRequest
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
            'description' => 'required|string|max:65535',
            'inactive' => 'sometimes|boolean',
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
            'description.required' => 'La description du tag est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser :max caractères.',
            'inactive.boolean' => 'Le champ inactive doit être un booléen.',
        ];
    }
}