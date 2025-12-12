<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CrmCustomersTag",
 *     type="object",
 *     title="CrmCustomersTag",
 *     description="Modèle de liaison entre clients et tags CRM",
 *     @OA\Property(
 *         property="id_crm_customers_tag",
 *         type="integer",
 *         description="ID unique de la liaison client-tag CRM",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_crm_tag",
 *         type="integer",
 *         description="ID du tag CRM",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
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
class CrmCustomersTag extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'crm_customers_tags';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_crm_customers_tag';

    /**
     * Indique si les IDs sont auto-incrémentés.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_crm_tag',
        'id_customer',
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
     * Relation avec le modèle CrmTag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crmTag()
    {
        return $this->belongsTo(CrmTag::class, 'id_crm_tag', 'id_crm_tag');
    }

    /**
     * Relation avec le modèle Customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}