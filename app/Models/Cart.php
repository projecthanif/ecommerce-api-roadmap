<?php

namespace App\Models;

class Cart extends AbstractModel
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
