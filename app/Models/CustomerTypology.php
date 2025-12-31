<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerTypology",
 *     type="object",
 *     title="CustomerTypology",
 *     description="Modèle de typologie client",
 *     @OA\Property(
 *         property="id_customer_typology",
 *         type="integer",
 *         description="ID unique de la typologie client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=50,
 *         description="Nom de la typologie",
 *         example="Particulier"
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
class CustomerTypology extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_typologies';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_typology';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'name' => '',
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
}