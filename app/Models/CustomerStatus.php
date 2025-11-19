<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerStatus",
 *     type="object",
 *     title="CustomerStatus",
 *     description="Représente un statut client",
 *     @OA\Property(property="id_customer_status", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Actif"),
 *     @OA\Property(property="color", type="string", example="#00FF00")
 * )
 */
class CustomerStatus extends Model
{
    protected $primaryKey = 'id_customer_status';
    public $incrementing = true;
    protected $keyType = 'int'; 

    protected $fillable = [
        'id_customer_status',
        'name',
        'color',
    ];
}
