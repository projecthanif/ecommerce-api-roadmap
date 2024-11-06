<?php

namespace App\Models;

class Order extends AbstractModel
{
    protected $fillable = [
        'user_id',
        'total_price',
    ];
}
