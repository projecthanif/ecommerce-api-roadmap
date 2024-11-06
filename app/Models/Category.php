<?php

namespace App\Models;

class Category extends AbstractModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
