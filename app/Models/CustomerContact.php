<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerContact",
 *     type="object",
 *     title="CustomerContact",
 *     description="Modèle de contact client",
 *     @OA\Property(
 *         property="id_customer_contact",
 *         type="integer",
 *         description="ID unique du contact client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
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
 *         property="phone_number",
 *         type="string",
 *         maxLength=16,
 *         description="Numéro de téléphone principal",
 *         example="0123456789"
 *     ),
 *     @OA\Property(
 *         property="email_address",
 *         type="string",
 *         maxLength=80,
 *         description="Adresse email",
 *         example="jean.dupont@example.com"
 *     ),
 *     @OA\Property(
 *         property="id_contact_title",
 *         type="integer",
 *         description="ID de la civilité",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone_number_2",
 *         type="string",
 *         maxLength=16,
 *         description="Numéro de téléphone secondaire",
 *         nullable=true,
 *         example="0987654321"
 *     ),
 *     @OA\Property(
 *         property="is_default",
 *         type="boolean",
 *         description="Indique si c'est le contact par défaut",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="id_contact_role",
 *         type="integer",
 *         description="ID du rôle du contact",
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
class CustomerContact extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_contacts';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_customer_contact';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer',
        'first_name',
        'last_name',
        'phone_number',
        'email_address',
        'id_contact_title',
        'phone_number_2',
        'is_default',
        'id_contact_role',
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
     * Relation avec le modèle Customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    /**
     * Relation avec le modèle CustomerContactTitle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactTitle()
    {
        return $this->belongsTo(CustomerContactTitle::class, 'id_contact_title', 'id_customer_contact_title');
    }

    /**
     * Relation avec le modèle CustomerContactRole.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactRole()
    {
        return $this->belongsTo(CustomerContactRole::class, 'id_contact_role', 'id_contact_role');
    }

    /**
     * Scope pour récupérer les contacts par défaut.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Boot method pour gérer la contrainte sur is_default.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->is_default) {
                // Désactiver les autres contacts par défaut pour ce client
                static::where('id_customer', $model->id_customer)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('is_default') && $model->is_default) {
                // Désactiver les autres contacts par défaut pour ce client
                static::where('id_customer', $model->id_customer)
                    ->where('id_customer_contact', '!=', $model->id_customer_contact)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        });
    }
}