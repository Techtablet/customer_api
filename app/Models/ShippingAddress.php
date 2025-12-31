<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ShippingAddress",
 *     type="object",
 *     title="ShippingAddress",
 *     description="Modèle d'adresse de livraison",
 *     @OA\Property(
 *         property="id_shipping_address",
 *         type="integer",
 *         description="ID unique de l'adresse de livraison",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer_address",
 *         type="integer",
 *         description="ID de l'adresse client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="is_default",
 *         type="boolean",
 *         description="Indique si c'est l'adresse de livraison par défaut",
 *         example=true,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="address_name",
 *         type="string",
 *         maxLength=64,
 *         nullable=true,
 *         description="Nom personnalisé de l'adresse",
 *         example="Domicile"
 *     ),
 *     @OA\Property(
 *         property="has_difficult_access",
 *         type="boolean",
 *         description="Accès difficile",
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
class ShippingAddress extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'shipping_addresses';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_shipping_address';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer_address',
        'id_customer',
        'is_default',
        'address_name',
        'has_difficult_access',
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
        'is_default' => 'boolean',
    ];

    /**
     * Relation avec le modèle CustomerAddress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'id_customer_address', 'id_customer_address');
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
     * Scope pour récupérer l'adresse de livraison par défaut.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Boot method pour gérer la contrainte unique sur is_default.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->is_default) {
                // Désactiver les autres adresses par défaut
                static::where('is_default', true)->update(['is_default' => false]);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('is_default') && $model->is_default) {
                // Désactiver les autres adresses par défaut
                static::where('id_shipping_address', '!=', $model->id_shipping_address)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        });
    }
}