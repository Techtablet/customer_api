<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
