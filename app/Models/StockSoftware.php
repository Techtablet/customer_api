<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSoftware extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_stock_software';

    protected $fillable = [
        'id_stock_software',
        'name',
    ];
}
