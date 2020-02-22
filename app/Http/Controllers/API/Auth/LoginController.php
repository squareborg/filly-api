<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * After successful authentication return the redirect url based on the users role
     *
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        //$route = $user->hasRole('admin') ? route('admin.index') : route('dashboard');
        $route = $user->hasRole('admin') ? route('affiliate.home') : route('affiliate.home');

        return response()->json(['redirect_url' => $route], Response::HTTP_OK);
    }
}
