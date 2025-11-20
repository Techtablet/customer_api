<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerCountry",
 *     type="object",
 *     title="CustomerCountry",
 *     description="Modèle de pays client",
 *     @OA\Property(
 *         property="id_customer_country",
 *         type="integer",
 *         description="ID unique du pays client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du pays en français",
 *         example="France"
 *     ),
 *     @OA\Property(
 *         property="name_en",
 *         type="string",
 *         maxLength=70,
 *         description="Nom du pays en anglais",
 *         example="France"
 *     ),
 *     @OA\Property(
 *         property="name_de",
 *         type="string",
 *         maxLength=70,
 *         description="Nom du pays en allemand",
 *         example="Frankreich"
 *     ),
 *     @OA\Property(
 *         property="isocode",
 *         type="string",
 *         maxLength=5,
 *         description="Code ISO du pays",
 *         example="FR"
 *     ),
 *     @OA\Property(
 *         property="ccn3",
 *         type="integer",
 *         nullable=true,
 *         description="Code numérique du pays",
 *         example=250
 *     ),
 *     @OA\Property(
 *         property="phone_code",
 *         type="string",
 *         maxLength=10,
 *         nullable=true,
 *         description="Indicatif téléphonique",
 *         example="+33"
 *     ),
 *     @OA\Property(
 *         property="is_intracom_vat",
 *         type="integer",
 *         description="Pays intracommunautaire pour TVA (0=non, 1=oui)",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="is_ue_export",
 *         type="integer",
 *         description="Pays UE pour export (0=non, 1=oui)",
 *         example=1
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
 *     )
 * )
 */
class CustomerCountry extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_countries';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_country';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_en',
        'name_de',
        'isocode',
        'ccn3',
        'phone_code',
        'is_intracom_vat',
        'is_ue_export',
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
        'is_intracom_vat' => 'integer',
        'is_ue_export' => 'integer',
        'ccn3' => 'integer',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_intracom_vat' => 0,
        'is_ue_export' => 0,
    ];
}