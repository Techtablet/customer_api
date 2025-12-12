<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerContactProfile",
 *     type="object",
 *     title="CustomerContactProfile",
 *     description="Modèle de liaison entre profils et contacts clients",
 *     @OA\Property(
 *         property="id_contact_profile",
 *         type="integer",
 *         description="ID unique de la liaison",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_profile",
 *         type="integer",
 *         description="ID du profil",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_contact",
 *         type="integer",
 *         description="ID du contact client",
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
class CustomerContactProfile extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_contact_profiles';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_contact_profile';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_profile',
        'id_contact',
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
     * Relation avec le modèle Profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id_profile', 'id_profile');
    }

    /**
     * Relation avec le modèle CustomerContact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customerContact()
    {
        return $this->belongsTo(CustomerContact::class, 'id_contact', 'id_customer_contact');
    }
}