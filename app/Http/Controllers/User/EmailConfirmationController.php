<?php

namespace App\Http\Controllers\User;


use App\Models\User;
use App\Models\ConfirmationToken;
use App\Http\Controllers\Controller;

class EmailConfirmationController extends Controller
{
    public function index($token)
    {
        try {
            $confirmationToken = ConfirmationToken::where('token', $token)
                ->where('action', ConfirmationToken::ACTION_CONFIRM_ACCOUNT)
                ->first();

            if (!$confirmationToken || !$confirmationToken->isValid()) {
                throw new \Exception('Invalid token or the token expired.');
            }

            $user = $confirmationToken->user;
            $user->update(['is_verified' => true]);
            $confirmationToken->delete();
            auth()->guard()->login($user);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        return redirect()->route('dashboard');
    }
}
