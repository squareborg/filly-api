<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\PasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    public function update(PasswordRequest $request)
    {
        try {
            $request->user()->update([
                'password' => bcrypt($request->get('new_password')),
            ]);
        } catch (\Exception $e) {
            Log::error('[PASSWORD_UPDATE]', [$e->getMessage()]);
            return redirect()->back()->with('error', __('general.error'));
        }

        return redirect()->back()->with('success', __('auth.password_changed'));
    }
}
