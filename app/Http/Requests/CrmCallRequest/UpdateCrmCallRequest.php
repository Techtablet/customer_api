<?php

namespace App\Http\Requests\CrmCallRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCrmCallRequest",
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_techtablet_seller",
 *         type="integer",
 *         description="ID du commercial TechTablet",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_crm_calls_status",
 *         type="integer",
 *         description="ID du statut de l'appel",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="comment",
 *         type="string",
 *         description="Commentaire de l'appel",
 *         example="Client intéressé par notre nouvelle offre"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de l'appel",
 *         example="2024-01-15 14:30:00"
 *     ),
 *     @OA\Property(
 *         property="shipping_done",
 *         type="integer",
 *         description="Indique si l'expédition a été faite",
 *         nullable=true,
 *         example=0
 *     )
 * )
 */
class UpdateCrmCallRequest extends FormRequest
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
            'id_customer' => 'sometimes|integer|exists:customers,id_customer',
            'id_techtablet_seller' => 'sometimes|integer|exists:techtablet_sellers,id_techtablet_seller',
            'id_crm_calls_status' => 'sometimes|integer|exists:crm_calls_statuses,id_crm_calls_status',
            'comment' => 'sometimes|string|max:65535',
            'date' => 'sometimes|date_format:Y-m-d H:i:s',
            'shipping_done' => 'nullable|integer|in:0,1',
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
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'id_techtablet_seller.exists' => 'Le commercial spécifié n\'existe pas.',
            'id_crm_calls_status.exists' => 'Le statut spécifié n\'existe pas.',
            'comment.string' => 'Le commentaire doit être une chaîne de caractères.',
            'comment.max' => 'Le commentaire ne peut pas dépasser :max caractères.',
            'date.date_format' => 'La date doit être au format YYYY-MM-DD HH:MM:SS.',
            'shipping_done.integer' => 'Le champ shipping_done doit être un entier.',
            'shipping_done.in' => 'Le champ shipping_done doit être 0 ou 1.',
        ];
    }
}