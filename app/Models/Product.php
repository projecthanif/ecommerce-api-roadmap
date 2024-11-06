<?php

namespace App\Models;

class Product extends AbstractModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'quantity',
        'image_url',
    ];
}
