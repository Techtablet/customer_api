<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     title="Customer",
 *     description="Modèle de client",
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID unique du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=100,
 *         description="Nom du client",
 *         example="TechCorp SARL"
 *     ),
 *     @OA\Property(
 *         property="siren",
 *         type="string",
 *         maxLength=32,
 *         description="Numéro SIREN",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="siret",
 *         type="string",
 *         maxLength=32,
 *         description="Numéro SIRET",
 *         example="12345678900010"
 *     ),
 *     @OA\Property(
 *         property="newsletter",
 *         type="integer",
 *         description="Abonnement à la newsletter",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="already_called",
 *         type="boolean",
 *         description="Déjà appelé",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="id_franchise",
 *         type="integer",
 *         description="ID de la franchise",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_stock_software",
 *         type="integer",
 *         description="ID du logiciel de stock",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="to_callback",
 *         type="boolean",
 *         description="À rappeler",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="id_status",
 *         type="integer",
 *         description="ID du statut client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_refusal_reason",
 *         type="integer",
 *         description="ID de la raison de refus",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="survey_actif",
 *         type="integer",
 *         description="Enquête active (1:actif, 0:inactif)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="survey_date_disabled",
 *         type="string",
 *         format="date",
 *         description="Date de désactivation de l'enquête",
 *         example="2024-12-31"
 *     ),
 *     @OA\Property(
 *         property="important",
 *         type="integer",
 *         description="Client important (1:important, 0:non important)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         description="Notes",
 *         example="Client fidèle depuis 5 ans"
 *     ),
 *     @OA\Property(
 *         property="reminder",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Rappel",
 *         example="2024-12-31 10:00:00"
 *     ),
 *     @OA\Property(
 *         property="seller_reminder",
 *         type="integer",
 *         description="Rappel vendeur",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="id_seller",
 *         type="integer",
 *         description="ID du vendeur Techtablet",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="repurchase_menu",
 *         type="integer",
 *         description="Menu de rachat",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="dropshipping_menu",
 *         type="integer",
 *         description="Menu dropshipping",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="dropshipping_fee",
 *         type="number",
 *         format="float",
 *         description="Frais de dropshipping",
 *         example=5.5
 *     ),
 *     @OA\Property(
 *         property="delivery_order",
 *         type="integer",
 *         description="Ordre de livraison",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="profil",
 *         type="integer",
 *         description="Profil",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="information_request_send",
 *         type="integer",
 *         description="Demande d'information envoyée",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="information_request_validated",
 *         type="integer",
 *         description="Demande d'information validée",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="information_request_validated_once",
 *         type="integer",
 *         description="Demande d'information validée une fois",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="ape",
 *         type="string",
 *         maxLength=20,
 *         description="Code APE",
 *         example="6201Z"
 *     ),
 *     @OA\Property(
 *         property="rcs",
 *         type="string",
 *         maxLength=40,
 *         description="Numéro RCS",
 *         example="Paris B 123 456 789"
 *     ),
 *     @OA\Property(
 *         property="tourist_area",
 *         type="integer",
 *         description="Zone touristique (2:pas encore demandé, 0:non, 1:oui)",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="denomination",
 *         type="string",
 *         maxLength=50,
 *         description="Dénomination",
 *         example="Formel"
 *     ),
 *     @OA\Property(
 *         property="id_store_group",
 *         type="integer",
 *         nullable=true,
 *         description="ID du groupe de magasins",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="shipping_schedule",
 *         type="string",
 *         description="Planning d'expédition",
 *         example="Lundi-Vendredi 9h-18h"
 *     ),
 *     @OA\Property(
 *         property="has_customer_order_number",
 *         type="integer",
 *         description="Possède un numéro de commande client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="last_website_key",
 *         type="string",
 *         maxLength=500,
 *         description="Dernière clé de site web",
 *         example="webkey_12345"
 *     ),
 *     @OA\Property(
 *         property="receive_stock_software_file",
 *         type="integer",
 *         description="Reçoit le fichier logiciel de stock",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="stock_software_file_format",
 *         type="integer",
 *         description="Format du fichier logiciel de stock (1:Wingsm, 2:3gwin, 3:generique, 4:Trépidai)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="supplier_id_for_techtablet",
 *         type="string",
 *         maxLength=250,
 *         description="ID fournisseur pour Techtablet",
 *         example="SUP12345"
 *     ),
 *     @OA\Property(
 *         property="internal_customer_id",
 *         type="string",
 *         maxLength=30,
 *         nullable=true,
 *         description="ID client interne",
 *         example="CUST001"
 *     ),
 *     @OA\Property(
 *         property="id_lang",
 *         type="integer",
 *         description="ID de la langue",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_shipping_plan",
 *         type="integer",
 *         description="ID du plan d'expédition",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_price_list_info",
 *         type="integer",
 *         description="ID de la liste de prix",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_location",
 *         type="integer",
 *         nullable=true,
 *         description="ID de la localisation",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_typology",
 *         type="integer",
 *         nullable=true,
 *         description="ID de la typologie",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_canvassing_step",
 *         type="integer",
 *         nullable=true,
 *         description="ID de l'étape de démarchage",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="refund_by_ic",
 *         type="integer",
 *         description="Remboursement par IC",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="repurchase_type",
 *         type="integer",
 *         description="Type de rachat (0:standard, 1:100%)",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="inactive",
 *         type="integer",
 *         description="Inactif (1:inscription non activée, 0:actif)",
 *         example=0
 *     ),
 *     @OA\Property(
 *         property="receive_credit_on_reprise_stock_validation",
 *         type="integer",
 *         description="Reçoit crédit sur validation reprise stock",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="featured_product",
 *         type="integer",
 *         description="Produit en vedette",
 *         example=0
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
 *         property="franchise",
 *         ref="#/components/schemas/Franchise",
 *         description="Franchise associée"
 *     ),
 *     @OA\Property(
 *         property="seller",
 *         ref="#/components/schemas/TechtabletSeller",
 *         description="Vendeur associé"
 *     ),
 *     @OA\Property(
 *         property="lang",
 *         ref="#/components/schemas/CustomerLang",
 *         description="Langue associée"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         ref="#/components/schemas/CustomerLocation",
 *         description="Localisation associée"
 *     ),
 *     @OA\Property(
 *         property="typology",
 *         ref="#/components/schemas/CustomerTypology",
 *         description="Typologie associée"
 *     ),
 *     @OA\Property(
 *         property="canvassing_step",
 *         ref="#/components/schemas/CustomerCanvassingStep",
 *         description="Étape de démarchage associée"
 *     ),
 *     @OA\Property(
 *         property="store_group",
 *         ref="#/components/schemas/StoreGroup",
 *         description="Groupe de magasins associé"
 *     ),
 *     @OA\Property(
 *         property="refusal_reason",
 *         ref="#/components/schemas/CustomerRefusalReason",
 *         description="Raison de refus associée"
 *     )
 * )
 */
class Customer extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer',
        'id_user',
        'name',
        'siren',
        'siret',
        'newsletter',
        'already_called',
        'id_franchise',
        'id_stock_software',
        'to_callback',
        'id_status',
        'id_refusal_reason',
        'survey_actif',
        'survey_date_disabled',
        'important',
        'notes',
        'reminder',
        'seller_reminder',
        'id_seller',
        'repurchase_menu',
        'dropshipping_menu',
        'dropshipping_fee',
        'delivery_order',
        'profil',
        'information_request_send',
        'information_request_validated',
        'information_request_validated_once',
        'ape',
        'rcs',
        'tourist_area',
        'denomination',
        'id_store_group',
        'shipping_schedule',
        'has_customer_order_number',
        'last_website_key',
        'receive_stock_software_file',
        'stock_software_file_format',
        'supplier_id_for_techtablet',
        'internal_customer_id',
        'id_lang',
        'id_shipping_plan',
        'id_price_list_info',
        'id_location',
        'id_typology',
        'id_canvassing_step',
        'refund_by_ic',
        'repurchase_type',
        'inactive',
        'receive_credit_on_reprise_stock_validation',
        'featured_product',
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
        'newsletter' => 'integer',
        'already_called' => 'boolean',
        'to_callback' => 'boolean',
        'survey_actif' => 'integer',
        'important' => 'integer',
        'reminder' => 'datetime',
        'seller_reminder' => 'integer',
        'repurchase_menu' => 'integer',
        'dropshipping_menu' => 'integer',
        'dropshipping_fee' => 'float',
        'delivery_order' => 'integer',
        'profil' => 'integer',
        'information_request_send' => 'integer',
        'information_request_validated' => 'integer',
        'information_request_validated_once' => 'integer',
        'tourist_area' => 'integer',
        'has_customer_order_number' => 'integer',
        'receive_stock_software_file' => 'integer',
        'stock_software_file_format' => 'integer',
        'refund_by_ic' => 'integer',
        'repurchase_type' => 'integer',
        'inactive' => 'integer',
        'receive_credit_on_reprise_stock_validation' => 'integer',
        'featured_product' => 'integer',
        'survey_date_disabled' => 'date',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'survey_actif' => 1,
        'important' => 0,
        'seller_reminder' => 0,
        'delivery_order' => 1,
        'profil' => 0,
        'tourist_area' => 2,
        'denomination' => 'Formel',
        'stock_software_file_format' => 1,
        'id_lang' => 1,
        'refund_by_ic' => 0,
        'repurchase_type' => 0,
        'inactive' => 0,
        'receive_credit_on_reprise_stock_validation' => 1,
        'featured_product' => 0,
    ];

    /**
     * Relation avec la franchise.
     */
    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class, 'id_franchise', 'id_franchise');
    }

    /**
     * Relation avec le vendeur Techtablet.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(TechtabletSeller::class, 'id_seller', 'id_techtablet_seller');
    }

    /**
     * Relation avec la langue.
     */
    public function lang(): BelongsTo
    {
        return $this->belongsTo(CustomerLang::class, 'id_lang', 'id_customer_lang');
    }

    /**
     * Relation avec la localisation.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(CustomerLocation::class, 'id_location', 'id_customer_location');
    }

    /**
     * Relation avec la typologie.
     */
    public function typology(): BelongsTo
    {
        return $this->belongsTo(CustomerTypology::class, 'id_typology', 'id_customer_typology');
    }

    /**
     * Relation avec l'étape de démarchage.
     */
    public function canvassing_step(): BelongsTo
    {
        return $this->belongsTo(CustomerCanvassingStep::class, 'id_canvassing_step', 'id_customer_canvassing_step');
    }

    /**
     * Relation avec le groupe de magasins.
     */
    public function store_group(): BelongsTo
    {
        return $this->belongsTo(StoreGroup::class, 'id_store_group', 'id_store_group');
    }

    /**
     * Relation avec la raison de refus.
     */
    public function refusal_reason(): BelongsTo
    {
        return $this->belongsTo(CustomerRefusalReason::class, 'id_refusal_reason', 'id_customer_refusal_reason');
    }
}