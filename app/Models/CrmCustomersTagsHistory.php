<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CrmCustomersTagsHistory",
 *     type="object",
 *     title="CrmCustomersTagsHistory",
 *     description="Modèle d'historique des tags CRM des clients",
 *     @OA\Property(
 *         property="id_crm_tags_history",
 *         type="integer",
 *         description="ID unique de l'entrée d'historique",
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
 *         description="Date et heure de l'ajout du tag"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification"
 *     )
 * )
 */
class CrmCustomersTagsHistory extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'crm_customers_tags_history';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_crm_tags_history';

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

    /**
     * Scope pour récupérer l'historique d'un client spécifique.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $customerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('id_customer', $customerId);
    }

    /**
     * Scope pour récupérer l'historique d'un tag spécifique.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $tagId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForTag($query, $tagId)
    {
        return $query->where('id_crm_tag', $tagId);
    }

    /**
     * Scope pour récupérer l'historique dans une période donnée.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope pour récupérer les entrées récentes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}