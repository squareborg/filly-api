<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\ConfirmationToken;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'min:8',
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $confirmationToken = $user->confirmationTokens()->create([
            'action' => ConfirmationToken::ACTION_CONFIRM_ACCOUNT
        ]);

        $user->notify(new EmailVerificationNotification($user, $confirmationToken));

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            event(new Registered($user = $this->create($request->all())));
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_OK);
    }
}
