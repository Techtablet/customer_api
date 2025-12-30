<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="Modèle d'utilisateur",
 *     @OA\Property(
 *         property="id_user",
 *         type="integer",
 *         description="ID unique de l'utilisateur",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"admin", "customer"},
 *         description="Type de l'utilisateur",
 *         example="admin"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Adresse email",
 *         example="admin@example.com"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de vérification de l'email",
 *         nullable=true,
 *         example="2024-01-15 10:30:00"
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
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'email',
        'user_key',
        'password',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Scope pour récupérer les administrateurs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->where('type', 'admin');
    }

    /**
     * Scope pour récupérer les clients.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCustomers($query)
    {
        return $query->where('type', 'customer');
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un client.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->type === 'customer';
    }
}