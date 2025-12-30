<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="StoreGroup",
 *     type="object",
 *     title="StoreGroup",
 *     description="Modèle de groupe de magasins",
 *     @OA\Property(
 *         property="id_store_group",
 *         type="integer",
 *         description="ID unique du groupe de magasins",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="group_name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du groupe",
 *         example="Groupe Paris Centre"
 *     ),
 *     @OA\Property(
 *         property="group_key",
 *         type="string",
 *         maxLength=100,
 *         description="Clé unique du groupe",
 *         example="PARIS_CENTRE_01"
 *     ),
 *     @OA\Property(
 *         property="group_logo",
 *         type="string",
 *         maxLength=200,
 *         nullable=true,
 *         description="Logo du groupe",
 *         example="logos/paris-centre.png"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=200,
 *         description="Prénom du responsable",
 *         example="Jean"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=200,
 *         description="Nom du responsable",
 *         example="Dupont"
 *     ),
 *     @OA\Property(
 *         property="is_sepa",
 *         type="integer",
 *         description="Activation SEPA (0=non, 1=oui)",
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
class StoreGroup extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'store_groups';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_store_group';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_store_group',
        'group_name',
        'group_key',
        'group_logo',
        'first_name',
        'last_name',
        'is_sepa',
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
        'is_sepa' => 'integer',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_sepa' => 0,
    ];
}