<?php

namespace App\Http\Controllers\User;

use App\Models\ConfirmationToken;
use App\Http\Controllers\Controller;

class DeleteConfirmationController extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($token)
    {
        try {
            $confirmationToken = ConfirmationToken::where('token', $token)
                ->where('action', ConfirmationToken::ACTION_DELETE_ACCOUNT)
                ->first();

            if (!$confirmationToken || !$confirmationToken->isValid()) {
                throw new \Exception('Invalid token or the token expired.');
            }

            $confirmationToken->user()->delete();
            $confirmationToken->delete();

            auth()->logout();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }

        return redirect()->route('login')->with('success', trans('user.account.deleted'));
    }
}
