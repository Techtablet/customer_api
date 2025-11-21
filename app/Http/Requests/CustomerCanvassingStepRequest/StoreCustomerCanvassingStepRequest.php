<?php

namespace App\Http\Requests\CustomerCanvassingStepRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerCanvassingStepRequest",
 *     required={"name", "order"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom de l'étape",
 *         example="Premier contact"
 *     ),
 *     @OA\Property(
 *         property="order",
 *         type="integer",
 *         description="Ordre d'affichage",
 *         example=1
 *     )
 * )
 */
class StoreCustomerCanvassingStepRequest extends FormRequest
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
            'name' => 'required|string|max:200|unique:customer_canvassing_steps,name',
            'order' => 'required|integer|min:0|unique:customer_canvassing_steps,order',
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
            'name.required' => 'Le nom de l\'étape est obligatoire.',
            'name.string' => 'Le nom de l\'étape doit être une chaîne de caractères.',
            'name.max' => 'Le nom de l\'étape ne peut pas dépasser :max caractères.',
            'name.unique' => 'Une étape avec ce nom existe déjà.',
            'order.required' => 'L\'ordre est obligatoire.',
            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'order.min' => 'L\'ordre ne peut pas être inférieur à :min.',
            'order.unique' => 'Une étape avec cet ordre existe déjà.',
        ];
    }
}