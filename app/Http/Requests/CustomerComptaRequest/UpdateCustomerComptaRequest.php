<?php

namespace App\Http\Requests\CustomerComptaRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerComptaRequest",
 *     @OA\Property(
 *         property="devise",
 *         type="string",
 *         maxLength=5,
 *         description="Devise",
 *         example="EUR"
 *     ),
 *     @OA\Property(
 *         property="tva_intra_number",
 *         type="string",
 *         maxLength=75,
 *         description="Numéro de TVA intracommunautaire",
 *         example="FR12345678901"
 *     ),
 *     @OA\Property(
 *         property="payment_mode",
 *         type="integer",
 *         description="Mode de paiement",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="rib_etablissement",
 *         type="string",
 *         maxLength=16,
 *         description="RIB établissement",
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="rib_guichet",
 *         type="string",
 *         maxLength=16,
 *         description="RIB guichet",
 *         example="67890"
 *     ),
 *     @OA\Property(
 *         property="rib_compte",
 *         type="string",
 *         maxLength=16,
 *         description="RIB compte",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="rib_cle",
 *         type="string",
 *         maxLength=16,
 *         description="RIB clé",
 *         example="12"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="integer",
 *         description="Remise",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="balance",
 *         type="number",
 *         format="float",
 *         description="Solde",
 *         example=1500.50
 *     ),
 *     @OA\Property(
 *         property="shipping_invoice",
 *         type="boolean",
 *         description="Facturation de livraison",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="en_cours",
 *         type="number",
 *         format="float",
 *         description="Montant en cours",
 *         example=500.25
 *     ),
 *     @OA\Property(
 *         property="future_payment_mode",
 *         type="integer",
 *         description="Futur mode de paiement",
 *         nullable=true,
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="future_payment_delay_type",
 *         type="string",
 *         maxLength=11,
 *         description="Type de délai de paiement futur",
 *         example="jours"
 *     ),
 *     @OA\Property(
 *         property="future_payment_delay",
 *         type="integer",
 *         description="Délai de paiement futur",
 *         nullable=true,
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="rolling_period_days",
 *         type="integer",
 *         description="Nombre de jours d'une période glissante",
 *         nullable=true,
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="rolling_period_amount",
 *         type="number",
 *         format="float",
 *         description="Montant pour une période glissante",
 *         nullable=true,
 *         example=1000.00
 *     ),
 *     @OA\Property(
 *         property="rolling_period_cron_date",
 *         type="string",
 *         format="date",
 *         description="Date Cron pour une période glissante",
 *         nullable=true,
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="bic",
 *         type="string",
 *         maxLength=500,
 *         description="BIC",
 *         nullable=true,
 *         example="ABCDEFGH"
 *     ),
 *     @OA\Property(
 *         property="iban",
 *         type="string",
 *         maxLength=500,
 *         description="IBAN",
 *         nullable=true,
 *         example="FR7630001007941234567890185"
 *     ),
 *     @OA\Property(
 *         property="grouped_invoice",
 *         type="boolean",
 *         description="Facture groupée",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="grouped_invoice_begin",
 *         type="string",
 *         format="date",
 *         description="Début de facturation groupée",
 *         nullable=true,
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="grouped_invoice_end",
 *         type="string",
 *         format="date",
 *         description="Fin de facturation groupée",
 *         nullable=true,
 *         example="2024-12-31"
 *     ),
 *     @OA\Property(
 *         property="cb_register_info",
 *         type="boolean",
 *         description="Enregistrement des infos CB",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="cb_register_always_ask",
 *         type="boolean",
 *         description="Toujours demander l'enregistrement CB",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="cb_token",
 *         type="string",
 *         maxLength=250,
 *         description="Token CB",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="cb_date_val",
 *         type="string",
 *         maxLength=4,
 *         description="Date de validité CB",
 *         nullable=true,
 *         example="0125"
 *     ),
 *     @OA\Property(
 *         property="cb_ref_abonne",
 *         type="string",
 *         maxLength=250,
 *         description="Référence abonné CB",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_mandat_reference",
 *         type="string",
 *         maxLength=20,
 *         description="Référence mandat SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_payment_type",
 *         type="string",
 *         maxLength=50,
 *         description="Type de paiement SEPA",
 *         example="REPETITIVE"
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_name",
 *         type="string",
 *         maxLength=150,
 *         description="Nom du débiteur SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address",
 *         type="string",
 *         maxLength=250,
 *         description="Adresse du débiteur SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address_pc",
 *         type="string",
 *         maxLength=64,
 *         description="Code postal du débiteur SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address_city",
 *         type="string",
 *         maxLength=75,
 *         description="Ville du débiteur SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_signature_location",
 *         type="string",
 *         maxLength=75,
 *         description="Lieu de signature SEPA",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sepa_signature_date",
 *         type="string",
 *         format="date",
 *         description="Date de signature SEPA",
 *         nullable=true,
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="sepa_request_validated",
 *         type="boolean",
 *         description="Demande SEPA validée",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="sepa_request_validated_once",
 *         type="boolean",
 *         description="Demande SEPA validée une fois",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="is_blprice",
 *         type="boolean",
 *         description="BL Prix",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="classic_invoice",
 *         type="boolean",
 *         description="Facture classique",
 *         example=true
 *     )
 * )
 */
class UpdateCustomerComptaRequest extends FormRequest
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
        $customerComptaId = $this->route('customer_compta');

        return [
            'id_customer' => [
                'sometimes',
                'integer',
                Rule::unique('customer_comptas', 'id_customer')->ignore($customerComptaId, 'id_customer_compta'),
                'exists:customers,id_customer',
            ],
            'devise' => 'sometimes|string|max:5',
            'tva_intra_number' => 'nullable|string|max:75',
            'payment_mode' => 'sometimes|integer',
            'rib_etablissement' => 'nullable|string|max:16',
            'rib_guichet' => 'nullable|string|max:16',
            'rib_compte' => 'nullable|string|max:16',
            'rib_cle' => 'nullable|string|max:16',
            'discount' => 'sometimes|integer',
            'balance' => 'sometimes|numeric|between:-9999999999.99,9999999999.99',
            'shipping_invoice' => 'sometimes|boolean',
            'en_cours' => 'sometimes|numeric|min:0',
            'future_payment_mode' => 'nullable|integer',
            'future_payment_delay_type' => 'sometimes|string|max:11',
            'future_payment_delay' => 'nullable|integer|min:0',
            'rolling_period_days' => 'nullable|integer|min:0',
            'rolling_period_amount' => 'nullable|numeric|min:0',
            'rolling_period_cron_date' => 'nullable|date',
            'bic' => 'nullable|string|max:500',
            'iban' => 'nullable|string|max:500',
            'grouped_invoice' => 'sometimes|boolean',
            'grouped_invoice_begin' => 'nullable|date|required_if:grouped_invoice,true',
            'grouped_invoice_end' => 'nullable|date|after_or_equal:grouped_invoice_begin|required_if:grouped_invoice,true',
            'cb_register_info' => 'sometimes|boolean',
            'cb_register_always_ask' => 'sometimes|boolean',
            'cb_token' => 'nullable|string|max:250',
            'cb_date_val' => 'nullable|string|max:4',
            'cb_ref_abonne' => 'nullable|string|max:250',
            'sepa_mandat_reference' => 'nullable|string|max:20',
            'sepa_payment_type' => 'sometimes|string|max:50|in:REPETITIVE,UNIQUE',
            'sepa_debtor_name' => 'nullable|string|max:150',
            'sepa_debtor_address' => 'nullable|string|max:250',
            'sepa_debtor_address_pc' => 'nullable|string|max:64',
            'sepa_debtor_address_city' => 'nullable|string|max:75',
            'sepa_signature_location' => 'nullable|string|max:75',
            'sepa_signature_date' => 'nullable|date',
            'sepa_request_validated' => 'sometimes|boolean',
            'sepa_request_validated_once' => 'sometimes|boolean',
            'is_blprice' => 'sometimes|boolean',
            'classic_invoice' => 'sometimes|boolean',
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
            'id_customer.unique' => 'Ce client a déjà une fiche comptable.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'sepa_payment_type.in' => 'Le type de paiement SEPA doit être soit REPETITIVE, soit UNIQUE.',
            'grouped_invoice_begin.required_if' => 'La date de début est requise pour une facturation groupée.',
            'grouped_invoice_end.required_if' => 'La date de fin est requise pour une facturation groupée.',
            'grouped_invoice_end.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
        ];
    }
}