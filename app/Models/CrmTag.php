<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CrmTag",
 *     type="object",
 *     title="CrmTag",
 *     description="Modèle de tag CRM",
 *     @OA\Property(
 *         property="id_crm_tag",
 *         type="integer",
 *         description="ID unique du tag CRM",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description du tag",
 *         example="Client important"
 *     ),
 *     @OA\Property(
 *         property="inactive",
 *         type="boolean",
 *         description="Indique si le tag est inactif",
 *         example=false
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
class CrmTag extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'crm_tags';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_crm_tag';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'inactive',
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
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'inactive' => 'boolean',
    ];

    /**
     * Scope pour récupérer uniquement les tags actifs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('inactive', false);
    }

    /**
     * Scope pour récupérer uniquement les tags inactifs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('inactive', true);
    }
}