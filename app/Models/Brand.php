<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends AbstractModel
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
