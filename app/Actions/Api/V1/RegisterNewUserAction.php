<?php

namespace App\Actions\Api\V1;

use App\Models\User;

class RegisterNewUserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private User $user,
    )
    {
    }

    public function execute(){}
}
