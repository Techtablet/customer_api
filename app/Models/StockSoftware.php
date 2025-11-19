<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="StockSoftware",
 *     type="object",
 *     title="StockSoftware",
 *     description="Représente un logiciel disponible",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Win GSM"),
 * )
 */
class StockSoftware extends Model
{
    use HasFactory;

    protected $table = 'stock_softwares';

    protected $primaryKey = 'id_stock_software';

    protected $fillable = [
        'id_stock_software',
        'name',
    ];
}
