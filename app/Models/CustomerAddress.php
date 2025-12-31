<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="CustomerAddress",
 *     type="object",
 *     title="CustomerAddress",
 *     description="Modèle d'adresse client",
 *     @OA\Property(
 *         property="id_customer_address",
 *         type="integer",
 *         description="ID unique de l'adresse client",
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
 *         property="address",
 *         type="string",
 *         maxLength=255,
 *         description="Adresse",
 *         example="123 Rue de la République"
 *     ),
 *     @OA\Property(
 *         property="complement_address",
 *         type="string",
 *         maxLength=200,
 *         nullable=true,
 *         description="Complément d'adresse",
 *         example="Bâtiment A, étage 2"
 *     ),
 *     @OA\Property(
 *         property="postal_code",
 *         type="string",
 *         maxLength=10,
 *         description="Code postal",
 *         example="75001"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         maxLength=64,
 *         description="Ville",
 *         example="Paris"
 *     ),
 *     @OA\Property(
 *         property="id_country",
 *         type="integer",
 *         description="ID du pays",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=20,
 *         description="Téléphone",
 *         example="+33123456789"
 *     ),
 *     @OA\Property(
 *         property="fax",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Fax",
 *         example="+33123456780"
 *     ),
 *     @OA\Property(
 *         property="longitude",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Longitude",
 *         example=2.3522219
 *     ),
 *     @OA\Property(
 *         property="latitude",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Latitude",
 *         example=48.856614
 *     ),
 *     @OA\Property(
 *         property="place_id",
 *         type="string",
 *         maxLength=150,
 *         nullable=true,
 *         description="ID de lieu Google Maps",
 *         example="ChIJD7fiBh9u5kcRYJSMaMOCCwQ"
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
 *         property="country",
 *         ref="#/components/schemas/CustomerCountry",
 *         description="Pays associé"
 *     )
 * )
 */
class CustomerAddress extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_addresses';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_address';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer_address',
        'first_name',
        'last_name',
        'address',
        'complement_address',
        'postal_code',
        'city',
        'id_country',
        'phone',
        'fax',
        'longitude',
        'latitude',
        'place_id',
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
        'longitude' => 'decimal:7',
        'latitude' => 'decimal:7',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        
    ];

    /**
     * Relation avec le pays.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(CustomerCountry::class, 'id_country', 'id_customer_country');
    }
}