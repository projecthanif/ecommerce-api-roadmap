<?php

namespace App\Models;

class OrderItem extends AbstractModel
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];
}
