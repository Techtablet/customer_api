<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerSchedule",
 *     type="object",
 *     title="CustomerSchedule",
 *     description="Modèle d'horaires client",
 *     @OA\Property(
 *         property="id_schedule",
 *         type="integer",
 *         description="ID unique de l'horaire",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="day",
 *         type="string",
 *         description="Jours d'ouverture (JSON array)",
 *         example="['1', '2', '3', '4', '5']"
 *     ),
 *     @OA\Property(
 *         property="opening_time",
 *         type="string",
 *         format="time",
 *         description="Heure d'ouverture",
 *         example="08:00:00"
 *     ),
 *     @OA\Property(
 *         property="closure_time",
 *         type="string",
 *         format="time",
 *         description="Heure de fermeture",
 *         example="18:00:00"
 *     ),
 *     @OA\Property(
 *         property="has_break",
 *         type="boolean",
 *         description="Indique si il y a une pause",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="break_time_begin",
 *         type="string",
 *         format="time",
 *         description="Heure de début de pause",
 *         nullable=true,
 *         example="12:00:00"
 *     ),
 *     @OA\Property(
 *         property="break_time_end",
 *         type="string",
 *         format="time",
 *         description="Heure de fin de pause",
 *         nullable=true,
 *         example="14:00:00"
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
class CustomerSchedule extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'customer_schedules';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_schedule';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer',
        'day',
        'opening_time',
        'closure_time',
        'has_break',
        'break_time_begin',
        'break_time_end',
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
        'day' => 'array',
        'has_break' => 'boolean',
        'opening_time' => 'datetime:H:i:s',
        'closure_time' => 'datetime:H:i:s',
        'break_time_begin' => 'datetime:H:i:s',
        'break_time_end' => 'datetime:H:i:s',
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
     * Accessor pour formater l'heure d'ouverture.
     *
     * @return string
     */
    public function getOpeningTimeAttribute($value)
    {
        return $value ? date('H:i', strtotime($value)) : null;
    }

    /**
     * Accessor pour formater l'heure de fermeture.
     *
     * @return string
     */
    public function getClosureTimeAttribute($value)
    {
        return $value ? date('H:i', strtotime($value)) : null;
    }

    /**
     * Accessor pour formater l'heure de début de pause.
     *
     * @return string|null
     */
    public function getBreakTimeBeginAttribute($value)
    {
        return $value ? date('H:i', strtotime($value)) : null;
    }

    /**
     * Accessor pour formater l'heure de fin de pause.
     *
     * @return string|null
     */
    public function getBreakTimeEndAttribute($value)
    {
        return $value ? date('H:i', strtotime($value)) : null;
    }

    /**
     * Mutator pour convertir le tableau de jours en JSON.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setDayAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['day'] = json_encode($value);
        } elseif (is_string($value) && json_decode($value) !== null) {
            $this->attributes['day'] = $value;
        } else {
            $this->attributes['day'] = json_encode([]);
        }
    }

    /**
     * Accessor pour obtenir les jours sous forme de tableau.
     *
     * @return array
     */
    public function getDayAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    /**
     * Scope pour récupérer les horaires d'un jour spécifique.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|int $day
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForDay($query, $day)
    {
        return $query->whereJsonContains('day', (string)$day);
    }

    /**
     * Scope pour récupérer les horaires en cours (actuellement ouverts).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrentlyOpen($query)
    {
        $currentDay = date('N'); // 1 (lundi) à 7 (dimanche)
        $currentTime = date('H:i:s');

        return $query->whereJsonContains('day', (string)$currentDay)
            ->where('opening_time', '<=', $currentTime)
            ->where('closure_time', '>=', $currentTime);
    }
}