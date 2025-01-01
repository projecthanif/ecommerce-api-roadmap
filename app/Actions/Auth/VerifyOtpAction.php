<?php
declare(strict_types=1);

namespace App\Actions\Auth;

class VerifyOtpAction
{

    public function handle(string $otp, string $email)
    {
        $email = cache()->get($email);

        dd($email);
    }

}
