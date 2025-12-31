<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="CustomerStat",
 *     type="object",
 *     title="CustomerStat",
 *     description="Modèle de statistiques client",
 *     @OA\Property(
 *         property="id_customer_stat",
 *         type="integer",
 *         description="ID unique des statistiques client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="arevage_ordervalue",
 *         type="number",
 *         format="float",
 *         description="Valeur moyenne des commandes",
 *         example=1500.75
 *     ),
 *     @OA\Property(
 *         property="last_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Dernière commande",
 *         example="2024-12-15"
 *     ),
 *     @OA\Property(
 *         property="first_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Première commande",
 *         example="2024-01-15"
 *     ),
 *     @OA\Property(
 *         property="profitability",
 *         type="number",
 *         format="float",
 *         description="Rentabilité totale",
 *         example=5000.25
 *     ),
 *     @OA\Property(
 *         property="profitabilityOneYear",
 *         type="number",
 *         format="float",
 *         description="Rentabilité sur un an",
 *         example=3000.50
 *     ),
 *     @OA\Property(
 *         property="profitabilityThreeMonth",
 *         type="number",
 *         format="float",
 *         description="Rentabilité sur trois mois",
 *         example=1000.75
 *     ),
 *     @OA\Property(
 *         property="turnover",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires total",
 *         example=25000.00
 *     ),
 *     @OA\Property(
 *         property="turnoverOneYear",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires sur un an",
 *         example=15000.00
 *     ),
 *     @OA\Property(
 *         property="turnoverThreeMonth",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires sur trois mois",
 *         example=5000.00
 *     ),
 *     @OA\Property(
 *         property="point1",
 *         type="number",
 *         format="float",
 *         description="Point 1",
 *         example=85.5
 *     ),
 *     @OA\Property(
 *         property="point2",
 *         type="number",
 *         format="float",
 *         description="Point 2",
 *         example=90.0
 *     ),
 *     @OA\Property(
 *         property="point3",
 *         type="number",
 *         format="float",
 *         description="Point 3",
 *         example=75.25
 *     ),
 *     @OA\Property(
 *         property="point4",
 *         type="number",
 *         format="float",
 *         description="Point 4",
 *         example=80.0
 *     ),
 *     @OA\Property(
 *         property="point5",
 *         type="number",
 *         format="float",
 *         description="Point 5",
 *         example=95.5
 *     ),
 *     @OA\Property(
 *         property="point6",
 *         type="number",
 *         format="float",
 *         description="Point 6",
 *         example=88.75
 *     ),
 *     @OA\Property(
 *         property="point7",
 *         type="number",
 *         format="float",
 *         description="Point 7",
 *         example=92.0
 *     ),
 *     @OA\Property(
 *         property="point8",
 *         type="number",
 *         format="float",
 *         description="Point 8",
 *         example=70.5
 *     ),
 *     @OA\Property(
 *         property="point9",
 *         type="number",
 *         format="float",
 *         description="Point 9",
 *         example=85.0
 *     ),
 *     @OA\Property(
 *         property="point10",
 *         type="number",
 *         format="float",
 *         description="Point 10",
 *         example=78.25
 *     ),
 *     @OA\Property(
 *         property="point11",
 *         type="number",
 *         format="float",
 *         description="Point 11",
 *         example=82.5
 *     ),
 *     @OA\Property(
 *         property="point12",
 *         type="number",
 *         format="float",
 *         description="Point 12",
 *         example=91.0
 *     ),
 *     @OA\Property(
 *         property="point13",
 *         type="number",
 *         format="float",
 *         description="Point 13",
 *         example=87.75
 *     ),
 *     @OA\Property(
 *         property="profitability_lifepercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité totale",
 *         example=20.5
 *     ),
 *     @OA\Property(
 *         property="profitability_yearrpercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité annuelle",
 *         example=18.75
 *     ),
 *     @OA\Property(
 *         property="profitability_threepercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité trimestrielle",
 *         example=15.25
 *     ),
 *     @OA\Property(
 *         property="promise_of_order_added",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Date d'ajout de la promesse de commande",
 *         example="2024-12-01"
 *     ),
 *     @OA\Property(
 *         property="promise_of_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Date de promesse de commande",
 *         example="2024-12-31"
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
class CustomerStat extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_stats';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_stat';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer_stat',
        'id_customer',
        'arevage_ordervalue',
        'last_order',
        'first_order',
        'profitability',
        'profitabilityOneYear',
        'profitabilityThreeMonth',
        'turnover',
        'turnoverOneYear',
        'turnoverThreeMonth',
        'point1',
        'point2',
        'point3',
        'point4',
        'point5',
        'point6',
        'point7',
        'point8',
        'point9',
        'point10',
        'point11',
        'point12',
        'point13',
        'profitability_lifepercent',
        'profitability_yearrpercent',
        'profitability_threepercent',
        'promise_of_order_added',
        'promise_of_order',
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
        'arevage_ordervalue' => 'float',
        'last_order' => 'date',
        'first_order' => 'date',
        'profitability' => 'float',
        'profitabilityOneYear' => 'float',
        'profitabilityThreeMonth' => 'float',
        'turnover' => 'float',
        'turnoverOneYear' => 'float',
        'turnoverThreeMonth' => 'float',
        'point1' => 'float',
        'point2' => 'float',
        'point3' => 'float',
        'point4' => 'float',
        'point5' => 'float',
        'point6' => 'float',
        'point7' => 'float',
        'point8' => 'float',
        'point9' => 'float',
        'point10' => 'float',
        'point11' => 'float',
        'point12' => 'float',
        'point13' => 'float',
        'profitability_lifepercent' => 'float',
        'profitability_yearrpercent' => 'float',
        'profitability_threepercent' => 'float',
        'promise_of_order_added' => 'date',
        'promise_of_order' => 'date',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'arevage_ordervalue' => 0,
        'profitability' => 0,
        'profitabilityOneYear' => 0,
        'profitabilityThreeMonth' => 0,
        'turnover' => 0,
        'turnoverOneYear' => 0,
        'turnoverThreeMonth' => 0,
        'point1' => 0,
        'point2' => 0,
        'point3' => 0,
        'point4' => 0,
        'point5' => 0,
        'point6' => 0,
        'point7' => 0,
        'point8' => 0,
        'point9' => 0,
        'point10' => 0,
        'point11' => 0,
        'point12' => 0,
        'point13' => 0,
        'profitability_lifepercent' => 0,
        'profitability_yearrpercent' => 0,
        'profitability_threepercent' => 0,
    ];

    /**
     * Relation avec le client.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}