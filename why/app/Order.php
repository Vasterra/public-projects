<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'order_number',
        'customer',
        'billing_address',
        'total_price',
        'created_at',
        'updated_at',
        'phone',
        'email',
        'zip',
        'latitude',
        'longitude',
        'status',
        'note',
        'error'
    ];
    //
}
