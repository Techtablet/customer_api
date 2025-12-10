<?php

namespace App\Http\Requests\CustomerComptaRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerComptaRequest",
 *     required={"id_customer", "tva_intra_number", "payment_mode", "rib_etablissement", "rib_guichet", "rib_compte", "rib_cle", "balance", "en_cours", "future_payment_mode", "future_payment_delay_type", "future_payment_delay", "grouped_invoice_begin", "grouped_invoice_end", "cb_token", "cb_date_val", "cb_ref_abonne", "sepa_mandat_reference", "sepa_debtor_name", "sepa_debtor_address", "sepa_debtor_address_pc", "sepa_debtor_address_city", "sepa_signature_location", "sepa_signature_date"},
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
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
 *         description="RIB - Établissement",
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="rib_guichet",
 *         type="string",
 *         maxLength=16,
 *         description="RIB - Guichet",
 *         example="67890"
 *     ),
 *     @OA\Property(
 *         property="rib_compte",
 *         type="string",
 *         maxLength=16,
 *         description="RIB - Compte",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="rib_cle",
 *         type="string",
 *         maxLength=16,
 *         description="RIB - Clé",
 *         example="12"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="integer",
 *         description="Remise",
 *         example=0
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
 *         description="Facture d'expédition",
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
 *         description="Mode de paiement futur",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="future_payment_delay_type",
 *         type="string",
 *         maxLength=11,
 *         description="Type de délai de paiement futur",
 *         example="JOURS"
 *     ),
 *     @OA\Property(
 *         property="future_payment_delay",
 *         type="integer",
 *         description="Délai de paiement futur",
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="rolling_period_days",
 *         type="integer",
 *         nullable=true,
 *         description="Nombre de jours d'une période glissante",
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="rolling_period_amount",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Montant pour une période glissante",
 *         example=1000.00
 *     ),
 *     @OA\Property(
 *         property="rolling_period_cron_date",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Date Cron pour une période glissante",
 *         example="2024-12-31"
 *     ),
 *     @OA\Property(
 *         property="bic",
 *         type="string",
 *         maxLength=500,
 *         nullable=true,
 *         description="BIC",
 *         example="BNPAFRPPXXX"
 *     ),
 *     @OA\Property(
 *         property="iban",
 *         type="string",
 *         maxLength=500,
 *         nullable=true,
 *         description="IBAN",
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
 *         description="Date de début de facturation groupée",
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="grouped_invoice_end",
 *         type="string",
 *         format="date",
 *         description="Date de fin de facturation groupée",
 *         example="2024-12-31"
 *     ),
 *     @OA\Property(
 *         property="cb_register_info",
 *         type="boolean",
 *         description="Informations CB enregistrées",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="cb_register_always_ask",
 *         type="boolean",
 *         description="Toujours demander CB",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="cb_token",
 *         type="string",
 *         maxLength=250,
 *         description="Token CB",
 *         example="tok_123456789"
 *     ),
 *     @OA\Property(
 *         property="cb_date_val",
 *         type="string",
 *         maxLength=4,
 *         description="Date de validité CB",
 *         example="0125"
 *     ),
 *     @OA\Property(
 *         property="cb_ref_abonne",
 *         type="string",
 *         maxLength=250,
 *         description="Référence abonné CB",
 *         example="ref_12345"
 *     ),
 *     @OA\Property(
 *         property="sepa_mandat_reference",
 *         type="string",
 *         maxLength=20,
 *         description="Référence mandat SEPA",
 *         example="MANDAT123456789"
 *     ),
 *     @OA\Property(
 *         property="sepa_payment_type",
 *         type="string",
 *         maxLength=50,
 *         description="Type de paiement SEPA (REPETITIVE, UNIQUE)",
 *         example="REPETITIVE"
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_name",
 *         type="string",
 *         maxLength=150,
 *         description="Nom débiteur SEPA",
 *         example="Jean Dupont"
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address",
 *         type="string",
 *         maxLength=250,
 *         description="Adresse débiteur SEPA",
 *         example="123 Rue de la République"
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address_pc",
 *         type="string",
 *         maxLength=64,
 *         description="Code postal débiteur SEPA",
 *         example="75001"
 *     ),
 *     @OA\Property(
 *         property="sepa_debtor_address_city",
 *         type="string",
 *         maxLength=75,
 *         description="Ville débiteur SEPA",
 *         example="Paris"
 *     ),
 *     @OA\Property(
 *         property="sepa_signature_location",
 *         type="string",
 *         maxLength=75,
 *         description="Lieu de signature SEPA",
 *         example="Paris"
 *     ),
 *     @OA\Property(
 *         property="sepa_signature_date",
 *         type="string",
 *         format="date",
 *         description="Date de signature SEPA",
 *         example="2024-01-15"
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
 *         description="Est BL Price",
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
class StoreCustomerComptaRequest extends FormRequest
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
            'id_customer' => 'required|integer|exists:customers,id_customer',
            'devise' => 'string|max:5',
            'tva_intra_number' => 'required|string|max:75',
            'payment_mode' => 'required|integer',
            'rib_etablissement' => 'required|string|max:16',
            'rib_guichet' => 'required|string|max:16',
            'rib_compte' => 'required|string|max:16',
            'rib_cle' => 'required|string|max:16',
            'discount' => 'integer',
            'balance' => 'required|numeric|between:-9999999999999.99,9999999999999.99',
            'shipping_invoice' => 'boolean',
            'en_cours' => 'required|numeric',
            'future_payment_mode' => 'required|integer',
            'future_payment_delay_type' => 'required|string|max:11',
            'future_payment_delay' => 'required|integer',
            'rolling_period_days' => 'nullable|integer|min:1',
            'rolling_period_amount' => 'nullable|numeric|between:-9999999999999.99,9999999999999.99',
            'rolling_period_cron_date' => 'nullable|date',
            'bic' => 'nullable|string|max:500',
            'iban' => 'nullable|string|max:500',
            'grouped_invoice' => 'boolean',
            'grouped_invoice_begin' => 'required|date',
            'grouped_invoice_end' => 'required|date|after_or_equal:grouped_invoice_begin',
            'cb_register_info' => 'boolean',
            'cb_register_always_ask' => 'boolean',
            'cb_token' => 'required|string|max:250',
            'cb_date_val' => 'required|string|size:4',
            'cb_ref_abonne' => 'required|string|max:250',
            'sepa_mandat_reference' => 'required|string|max:20',
            'sepa_payment_type' => 'string|max:50|in:REPETITIVE,UNIQUE',
            'sepa_debtor_name' => 'required|string|max:150',
            'sepa_debtor_address' => 'required|string|max:250',
            'sepa_debtor_address_pc' => 'required|string|max:64',
            'sepa_debtor_address_city' => 'required|string|max:75',
            'sepa_signature_location' => 'required|string|max:75',
            'sepa_signature_date' => 'required|date',
            'sepa_request_validated' => 'boolean',
            'sepa_request_validated_once' => 'boolean',
            'is_blprice' => 'boolean',
            'classic_invoice' => 'boolean',
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
            'id_customer.required' => 'Le client est obligatoire.',
            'id_customer.exists' => 'Le client sélectionné n\'existe pas.',
            'devise.max' => 'La devise ne peut pas dépasser :max caractères.',
            'tva_intra_number.required' => 'Le numéro de TVA intracommunautaire est obligatoire.',
            'tva_intra_number.max' => 'Le numéro de TVA intracommunautaire ne peut pas dépasser :max caractères.',
            'payment_mode.required' => 'Le mode de paiement est obligatoire.',
            'rib_etablissement.required' => 'Le RIB établissement est obligatoire.',
            'rib_etablissement.max' => 'Le RIB établissement ne peut pas dépasser :max caractères.',
            'rib_guichet.required' => 'Le RIB guichet est obligatoire.',
            'rib_guichet.max' => 'Le RIB guichet ne peut pas dépasser :max caractères.',
            'rib_compte.required' => 'Le RIB compte est obligatoire.',
            'rib_compte.max' => 'Le RIB compte ne peut pas dépasser :max caractères.',
            'rib_cle.required' => 'Le RIB clé est obligatoire.',
            'rib_cle.max' => 'Le RIB clé ne peut pas dépasser :max caractères.',
            'balance.required' => 'Le solde est obligatoire.',
            'balance.numeric' => 'Le solde doit être un nombre.',
            'balance.between' => 'Le solde doit être compris entre -9 999 999 999 999,99 et 9 999 999 999 999,99.',
            'en_cours.required' => 'Le montant en cours est obligatoire.',
            'en_cours.numeric' => 'Le montant en cours doit être un nombre.',
            'future_payment_mode.required' => 'Le mode de paiement futur est obligatoire.',
            'future_payment_delay_type.required' => 'Le type de délai de paiement futur est obligatoire.',
            'future_payment_delay_type.max' => 'Le type de délai de paiement futur ne peut pas dépasser :max caractères.',
            'future_payment_delay.required' => 'Le délai de paiement futur est obligatoire.',
            'rolling_period_days.min' => 'Le nombre de jours de période glissante doit être d\'au moins :min.',
            'rolling_period_amount.between' => 'Le montant de période glissante doit être compris entre -9 999 999 999 999,99 et 9 999 999 999 999,99.',
            'grouped_invoice_begin.required' => 'La date de début de facturation groupée est obligatoire.',
            'grouped_invoice_end.required' => 'La date de fin de facturation groupée est obligatoire.',
            'grouped_invoice_end.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'cb_token.required' => 'Le token CB est obligatoire.',
            'cb_token.max' => 'Le token CB ne peut pas dépasser :max caractères.',
            'cb_date_val.required' => 'La date de validité CB est obligatoire.',
            'cb_date_val.size' => 'La date de validité CB doit avoir :size caractères.',
            'cb_ref_abonne.required' => 'La référence abonné CB est obligatoire.',
            'cb_ref_abonne.max' => 'La référence abonné CB ne peut pas dépasser :max caractères.',
            'sepa_mandat_reference.required' => 'La référence mandat SEPA est obligatoire.',
            'sepa_mandat_reference.max' => 'La référence mandat SEPA ne peut pas dépasser :max caractères.',
            'sepa_payment_type.in' => 'Le type de paiement SEPA doit être REPETITIVE ou UNIQUE.',
            'sepa_debtor_name.required' => 'Le nom débiteur SEPA est obligatoire.',
            'sepa_debtor_name.max' => 'Le nom débiteur SEPA ne peut pas dépasser :max caractères.',
            'sepa_debtor_address.required' => 'L\'adresse débiteur SEPA est obligatoire.',
            'sepa_debtor_address.max' => 'L\'adresse débiteur SEPA ne peut pas dépasser :max caractères.',
            'sepa_debtor_address_pc.required' => 'Le code postal débiteur SEPA est obligatoire.',
            'sepa_debtor_address_pc.max' => 'Le code postal débiteur SEPA ne peut pas dépasser :max caractères.',
            'sepa_debtor_address_city.required' => 'La ville débiteur SEPA est obligatoire.',
            'sepa_debtor_address_city.max' => 'La ville débiteur SEPA ne peut pas dépasser :max caractères.',
            'sepa_signature_location.required' => 'Le lieu de signature SEPA est obligatoire.',
            'sepa_signature_location.max' => 'Le lieu de signature SEPA ne peut pas dépasser :max caractères.',
            'sepa_signature_date.required' => 'La date de signature SEPA est obligatoire.',
        ];
    }
}