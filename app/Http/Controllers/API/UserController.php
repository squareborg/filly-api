<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Http\Requests\ProfileUpdateRequest;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    const LOG_TAG = '[API_USER]';

    public function index(Request $request)
    {
        return fractal()->item($request->user())
            ->transformWith(new UserTransformer())
            ->parseIncludes(['affiliate_stats','merchant','merchant.stats'])
            ->respond(Response::HTTP_OK);
    }

    public function update(ProfileUpdateRequest $request)
    {
        try {
            if ($request->get('email', auth()->user()->email) !== auth()->user()->email) {
                auth()->user()->startEmailUpdate($request->get('email'));
            }
            $user = $request->user();
            $data = $request->except(['avatar']);
            $data['email'] = $user->email;
            $user->update($data);
        } catch (\Exception $e) {
            return $this->logExceptionAndRespond($e, self::LOG_TAG);
        }

        return fractal()->item($user)
            ->transformWith(new UserTransformer)
            ->parseIncludes(['merchant'])
            ->respond(Response::HTTP_OK);
    }
}
