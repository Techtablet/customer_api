<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="CustomerCompta",
 *     type="object",
 *     title="CustomerCompta",
 *     description="Modèle de comptabilité client",
 *     @OA\Property(
 *         property="id_customer_compta",
 *         type="integer",
 *         description="ID unique de la comptabilité client",
 *         example=1
 *     ),
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
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification"
 *     ),
 *     @OA\Property(
 *         property="customer",
 *         ref="#/components/schemas/Customer",
 *         description="Client associé"
 *     )
 * )
 */
class CustomerCompta extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_comptas';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_compta';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer',
        'devise',
        'tva_intra_number',
        'payment_mode',
        'rib_etablissement',
        'rib_guichet',
        'rib_compte',
        'rib_cle',
        'discount',
        'balance',
        'shipping_invoice',
        'en_cours',
        'future_payment_mode',
        'future_payment_delay_type',
        'future_payment_delay',
        'rolling_period_days',
        'rolling_period_amount',
        'rolling_period_cron_date',
        'bic',
        'iban',
        'grouped_invoice',
        'grouped_invoice_begin',
        'grouped_invoice_end',
        'cb_register_info',
        'cb_register_always_ask',
        'cb_token',
        'cb_date_val',
        'cb_ref_abonne',
        'sepa_mandat_reference',
        'sepa_payment_type',
        'sepa_debtor_name',
        'sepa_debtor_address',
        'sepa_debtor_address_pc',
        'sepa_debtor_address_city',
        'sepa_signature_location',
        'sepa_signature_date',
        'sepa_request_validated',
        'sepa_request_validated_once',
        'is_blprice',
        'classic_invoice',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Les casts de type pour les attributs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount' => 'integer',
        'balance' => 'decimal:2',
        'shipping_invoice' => 'boolean',
        'en_cours' => 'float',
        'future_payment_mode' => 'integer',
        'future_payment_delay' => 'integer',
        'rolling_period_days' => 'integer',
        'rolling_period_amount' => 'decimal:2',
        'rolling_period_cron_date' => 'date',
        'grouped_invoice' => 'boolean',
        'grouped_invoice_begin' => 'date',
        'grouped_invoice_end' => 'date',
        'cb_register_info' => 'boolean',
        'cb_register_always_ask' => 'boolean',
        'sepa_signature_date' => 'date',
        'sepa_request_validated' => 'boolean',
        'sepa_request_validated_once' => 'boolean',
        'is_blprice' => 'boolean',
        'classic_invoice' => 'boolean',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'devise' => 'EUR',
        'discount' => 0,
        'shipping_invoice' => true,
        'grouped_invoice' => false,
        'cb_register_info' => false,
        'cb_register_always_ask' => true,
        'sepa_payment_type' => 'REPETITIVE',
        'sepa_request_validated' => false,
        'sepa_request_validated_once' => false,
        'is_blprice' => false,
        'classic_invoice' => true,
    ];

    /**
     * Relation avec le client.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}