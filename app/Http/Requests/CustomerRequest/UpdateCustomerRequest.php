<?php

namespace App\Http\Requests\CustomerRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerRequest",
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
 *     )
 * )
 */
class UpdateCustomerRequest extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'siren' => 'sometimes|string|max:32',
            'siret' => 'sometimes|string|max:32',
            'newsletter' => 'sometimes|integer|in:0,1,2',
            'already_called' => 'sometimes|boolean',
            'id_franchise' => 'nullable|integer|exists:franchises,id_franchise',
            'id_stock_software' => 'nullable|integer|exists:stock_softwares,id_stock_software',
            'to_callback' => 'sometimes|boolean',
            'id_status' => 'sometimes|integer|exists:customer_statuses,id_customer_status',
            'id_refusal_reason' => 'nullable|integer|exists:customer_refusal_reasons,id_customer_refusal_reason',
            'survey_actif' => 'sometimes|integer|in:0,1',
            'survey_date_disabled' => 'nullable|date',
            'important' => 'sometimes|integer|in:0,1',
            'notes' => 'nullable|string',
            'reminder' => 'nullable|date',
            'seller_reminder' => 'sometimes|integer',
            'id_seller' => 'nullable|integer|exists:techtablet_sellers,id_techtablet_seller',
            'repurchase_menu' => 'sometimes|integer',
            'dropshipping_menu' => 'sometimes|integer',
            'dropshipping_fee' => 'nullable|numeric|min:0',
            'delivery_order' => 'sometimes|integer',
            'profil' => 'sometimes|integer',
            'information_request_send' => 'sometimes|integer',
            'information_request_validated' => 'sometimes|integer',
            'information_request_validated_once' => 'sometimes|integer',
            'ape' => 'nullable|string|max:20',
            'rcs' => 'nullable|string|max:40',
            'tourist_area' => 'sometimes|integer|in:0,1,2',
            'denomination' => 'sometimes|string|max:50',
            'id_store_group' => 'nullable|integer|exists:store_groups,id_store_group',
            'shipping_schedule' => 'sometimes|string',
            'has_customer_order_number' => 'sometimes|integer',
            'last_website_key' => 'nullable|string|max:500',
            'receive_stock_software_file' => 'sometimes|integer',
            'stock_software_file_format' => 'sometimes|integer|in:1,2,3,4',
            'supplier_id_for_techtablet' => 'nullable|string|max:250',
            'internal_customer_id' => 'nullable|string|max:30',
            'id_lang' => 'sometimes|integer|exists:customer_langs,id_customer_lang',
            'id_shipping_plan' => 'sometimes|integer',
            'id_price_list_info' => 'sometimes|integer',
            'id_location' => 'nullable|integer|exists:customer_locations,id_customer_location',
            'id_typology' => 'nullable|integer|exists:customer_typologies,id_customer_typology',
            'id_canvassing_step' => 'nullable|integer|exists:customer_canvassing_steps,id_customer_canvassing_step',
            'refund_by_ic' => 'sometimes|integer|in:0,1',
            'repurchase_type' => 'sometimes|integer|in:0,1',
            'inactive' => 'sometimes|integer|in:0,1',
            'receive_credit_on_reprise_stock_validation' => 'sometimes|integer|in:0,1',
            'featured_product' => 'sometimes|integer|in:0,1',
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
            'name.max' => 'Le nom du client ne peut pas dépasser :max caractères.',
            'siren.max' => 'Le SIREN ne peut pas dépasser :max caractères.',
            'siret.max' => 'Le SIRET ne peut pas dépasser :max caractères.',
            'newsletter.in' => 'Le champ newsletter doit être 0, 1 ou 2.',
            'id_franchise.exists' => 'La franchise sélectionnée n\'existe pas.',
            'id_stock_software.exists' => 'Le logiciel de stock sélectionné n\'existe pas.',
            'id_status.exists' => 'Le statut sélectionné n\'existe pas.',
            'id_refusal_reason.exists' => 'La raison de refus sélectionnée n\'existe pas.',
            'id_seller.exists' => 'Le vendeur sélectionné n\'existe pas.',
            'dropshipping_fee.numeric' => 'Les frais de dropshipping doivent être un nombre.',
            'ape.max' => 'Le code APE ne peut pas dépasser :max caractères.',
            'rcs.max' => 'Le RCS ne peut pas dépasser :max caractères.',
            'id_store_group.exists' => 'Le groupe de magasins sélectionné n\'existe pas.',
            'last_website_key.max' => 'La dernière clé de site web ne peut pas dépasser :max caractères.',
            'supplier_id_for_techtablet.max' => 'L\'ID fournisseur pour Techtablet ne peut pas dépasser :max caractères.',
            'id_lang.exists' => 'La langue sélectionnée n\'existe pas.',
            'id_location.exists' => 'La localisation sélectionnée n\'existe pas.',
            'id_typology.exists' => 'La typologie sélectionnée n\'existe pas.',
            'id_canvassing_step.exists' => 'L\'étape de démarchage sélectionnée n\'existe pas.',
        ];
    }
}