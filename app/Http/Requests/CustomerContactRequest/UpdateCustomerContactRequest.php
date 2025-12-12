<?php

namespace App\Http\Requests\CustomerContactRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerContactRequest",
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=64,
 *         description="Prénom",
 *         example="Jean"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=64,
 *         description="Nom",
 *         example="Dupont"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         maxLength=16,
 *         description="Numéro de téléphone principal",
 *         example="0123456789"
 *     ),
 *     @OA\Property(
 *         property="email_address",
 *         type="string",
 *         maxLength=80,
 *         description="Adresse email",
 *         example="jean.dupont@example.com"
 *     ),
 *     @OA\Property(
 *         property="id_contact_title",
 *         type="integer",
 *         description="ID de la civilité",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone_number_2",
 *         type="string",
 *         maxLength=16,
 *         description="Numéro de téléphone secondaire",
 *         nullable=true,
 *         example="0987654321"
 *     ),
 *     @OA\Property(
 *         property="is_default",
 *         type="boolean",
 *         description="Indique si c'est le contact par défaut",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="id_contact_role",
 *         type="integer",
 *         description="ID du rôle du contact",
 *         example=1
 *     )
 * )
 */
class UpdateCustomerContactRequest extends FormRequest
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
            'first_name' => 'sometimes|string|max:64',
            'last_name' => 'sometimes|string|max:64',
            'phone_number' => 'sometimes|string|max:16',
            'email_address' => 'sometimes|email|max:80',
            'id_contact_title' => 'sometimes|integer|exists:customer_contact_titles,id_customer_contact_title',
            'phone_number_2' => 'nullable|string|max:16',
            'is_default' => 'sometimes|boolean',
            'id_contact_role' => 'sometimes|integer|exists:customer_contact_roles,id_contact_role',
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
            'first_name.max' => 'Le prénom ne peut pas dépasser :max caractères.',
            'last_name.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'phone_number.max' => 'Le numéro de téléphone ne peut pas dépasser :max caractères.',
            'email_address.email' => 'L\'adresse email doit être valide.',
            'email_address.max' => 'L\'adresse email ne peut pas dépasser :max caractères.',
            'id_contact_title.exists' => 'La civilité spécifiée n\'existe pas.',
            'phone_number_2.max' => 'Le numéro de téléphone secondaire ne peut pas dépasser :max caractères.',
            'id_contact_role.exists' => 'Le rôle spécifié n\'existe pas.',
        ];
    }

    /**
     * Préparer les données pour validation.
     */
    protected function prepareForValidation()
    {
        $customerContactId = $this->route('customer_contact');
        
        // Si is_default est true, vérifier s'il y a déjà un contact par défaut pour ce client
        if ($this->has('is_default') && $this->is_default) {
            $customerContact = \App\Models\CustomerContact::find($customerContactId);
            $customerId = $this->has('id_customer') ? $this->id_customer : ($customerContact ? $customerContact->id_customer : null);
            
            if ($customerId) {
                $hasDefaultContact = \App\Models\CustomerContact::where('id_customer', $customerId)
                    ->where('id_customer_contact', '!=', $customerContactId)
                    ->where('is_default', true)
                    ->exists();
                
                if ($hasDefaultContact && (!$customerContact || !$customerContact->is_default)) {
                    $this->merge([
                        'is_default' => false,
                    ]);
                }
            }
        }
    }
}