<?php

namespace App\Observers;


use App\Models\ConfirmationToken;
use Illuminate\Support\Str;

class ConfirmationTokenObserver
{
    const EXPIRES_IN_MINUTES = 15;

    /**
     * Handle the creating event.
     *
     * @param ConfirmationToken $confirmationToken
     */
    public function creating(ConfirmationToken $confirmationToken)
    {
        $confirmationToken->token = Str::random(64);

        if (!$confirmationToken->expires_at) {
            $confirmationToken->expires_at = now()->addMinutes(self::EXPIRES_IN_MINUTES);
        }
    }
}
