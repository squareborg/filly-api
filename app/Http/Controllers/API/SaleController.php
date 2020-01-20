<?php

namespace App\Http\Controllers\API;

use function foo\func;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Sale;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Auth\UserRequestedActivationEmail;
use Illuminate\Foundation\Auth\Authenticatesprograms;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;


class SaleController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::debug('sale: invoke');
        $xfil = Cookie::get('XFIL');
        if ($xfil) {
            Log::debug('sale: have xfil cookie');
            $subscriptionUuids = explode(';',\Crypt::decryptString($xfil));
            Log::debug('sale: subscriptionUuids' . print_r($subscriptionUuids, true));
            $matchedSubscriptions = [];
            foreach ($subscriptionUuids as $subscriptionUuid) {
                $sub = Subscription::where('uuid', $subscriptionUuid)->first();
                if ($sub) {
                    $program = $sub->program()->where('uuid', $request->input('xfil_ids'))->first();
                    if ($program) {
                        array_push($matchedSubscriptions, $sub);
                    }
                }
            }
            Log::debug('sale: matchedSubscriptions:');

            $matchedSubscriptions = collect($matchedSubscriptions);
            $matchedSubscriptions->each(function($sub){
                Log::debug('sale matchedSubscription: ' . $sub->uuid);
            });
            if ($matchedSubscriptions->count() > 0 ){
                Log::debug('sale: have matched subs');
                    $res = $matchedSubscriptions->first(function($sub) use ($request){
                        return $sub->addSale($request->input('order_id'),$request->input('order_total'));
                    });
                    if($res){
                        return response(null, Response::HTTP_CREATED);
                    }
                    else{
                        // we have seen this sale before lets just say ok
                        return response(null, Response::HTTP_OK);
                    }

                }
            else {
                Log::debug('sale: no matched subs');
                return response(null, Response::HTTP_BAD_REQUEST);
            }
        }
        else{
            Log::debug('sale: no xfil cookie');

        }
        Log::debug('sale: end');
        return response(null, Response::HTTP_BAD_REQUEST);
    }


}
