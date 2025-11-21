<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TechtabletSeller",
 *     type="object",
 *     title="TechtabletSeller",
 *     description="Modèle de vendeur Techtablet",
 *     @OA\Property(
 *         property="id_techtablet_seller",
 *         type="integer",
 *         description="ID unique du vendeur Techtablet",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=50,
 *         description="Prénom",
 *         example="Pierre"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=50,
 *         nullable=true,
 *         description="Nom",
 *         example="Martin"
 *     ),
 *     @OA\Property(
 *         property="primary_phone",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Téléphone principal",
 *         example="+33123456789"
 *     ),
 *     @OA\Property(
 *         property="secondary_phone",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Téléphone secondaire",
 *         example="+33612345678"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         maxLength=150,
 *         nullable=true,
 *         description="Email professionnel",
 *         example="pierre.martin@techtablet.com"
 *     ),
 *     @OA\Property(
 *         property="job_title",
 *         type="string",
 *         maxLength=100,
 *         nullable=true,
 *         description="Poste/emploi occupé",
 *         example="Commercial Senior"
 *     ),
 *     @OA\Property(
 *         property="employee_code",
 *         type="string",
 *         maxLength=30,
 *         description="Code employé unique",
 *         example="EMP001"
 *     ),
 *     @OA\Property(
 *         property="digital_signature",
 *         type="string",
 *         nullable=true,
 *         description="Signature numérique",
 *         example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA..."
 *     ),
 *     @OA\Property(
 *         property="is_active",
 *         type="boolean",
 *         description="Statut actif",
 *         example=true
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
class TechtabletSeller extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'techtablet_sellers';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_techtablet_seller';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'primary_phone',
        'secondary_phone',
        'email',
        'job_title',
        'employee_code',
        'digital_signature',
        'is_active',
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
        'is_active' => 'boolean',
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];
}