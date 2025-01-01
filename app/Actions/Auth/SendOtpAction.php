<?php
declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Notifications\Auth\OtpNotification;
use Illuminate\Support\Facades\Notification;

class SendOtpAction
{
    public function handle(User $user): void
    {
        $otp = fake()->unique()->numberBetween(1000, 9999);
        cache()->put($user->email, $otp, now()->addMinutes(30));
        Notification::send($user, new OtpNotification($user, $otp));
    }
}
