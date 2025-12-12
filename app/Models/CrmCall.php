<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CrmCall",
 *     type="object",
 *     title="CrmCall",
 *     description="Modèle d'appel CRM",
 *     @OA\Property(
 *         property="id_crm_call",
 *         type="integer",
 *         description="ID unique de l'appel CRM",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_techtablet_seller",
 *         type="integer",
 *         description="ID du commercial TechTablet",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_crm_calls_status",
 *         type="integer",
 *         description="ID du statut de l'appel",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="comment",
 *         type="string",
 *         description="Commentaire de l'appel",
 *         example="Client intéressé par notre nouvelle offre"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de l'appel",
 *         example="2024-01-15 14:30:00"
 *     ),
 *     @OA\Property(
 *         property="shipping_done",
 *         type="integer",
 *         description="Indique si l'expédition a été faite",
 *         nullable=true,
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
 *     )
 * )
 */
class CrmCall extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'crm_calls';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_crm_call';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer',
        'id_techtablet_seller',
        'id_crm_calls_status',
        'comment',
        'date',
        'shipping_done',
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
        'date' => 'datetime',
        'shipping_done' => 'integer',
    ];

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
     * Relation avec le modèle TechtabletSeller.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function techtabletSeller()
    {
        return $this->belongsTo(TechtabletSeller::class, 'id_techtablet_seller', 'id_techtablet_seller');
    }

    /**
     * Relation avec le modèle CrmCallsStatus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crmCallsStatus()
    {
        return $this->belongsTo(CrmCallsStatus::class, 'id_crm_calls_status', 'id_crm_calls_status');
    }

    /**
     * Scope pour récupérer les appels d'un client spécifique.
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
     * Scope pour récupérer les appels d'un commercial spécifique.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $sellerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('id_techtablet_seller', $sellerId);
    }

    /**
     * Scope pour récupérer les appels avec un statut spécifique.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $statusId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $statusId)
    {
        return $query->where('id_crm_calls_status', $statusId);
    }

    /**
     * Scope pour récupérer les appels dans une période donnée.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope pour récupérer les appels récents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('date', '>=', now()->subDays($days));
    }

    /**
     * Scope pour récupérer les appels avec expédition faite.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithShippingDone($query)
    {
        return $query->where('shipping_done', 1);
    }

    /**
     * Scope pour récupérer les appels sans expédition faite.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutShippingDone($query)
    {
        return $query->where('shipping_done', 0)->orWhereNull('shipping_done');
    }
}