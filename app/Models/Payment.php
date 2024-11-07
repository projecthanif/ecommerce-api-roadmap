<?php

namespace App\Models;

use App\Enums\PaymentStatus;

class Payment extends AbstractModel
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'payment_method',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => PaymentStatus::class,
        ];
    }
}
