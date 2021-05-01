<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Traits\PassportToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    use PassportToken;

    const OAUTH_CLIENT_ID = 1;

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'lang' => $request->get('lang'),
            ]);

            $payload = $this->getBearerTokenByUser($user, self::OAUTH_CLIENT_ID, false);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($payload, Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                return response()->json(null, Response::HTTP_UNAUTHORIZED);
            }

            $user = User::where('email', $request->get('email'))->firstOrFail();
            $payload = $this->getBearerTokenByUser($user, self::OAUTH_CLIENT_ID, false);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($payload, Response::HTTP_OK);
    }
}
