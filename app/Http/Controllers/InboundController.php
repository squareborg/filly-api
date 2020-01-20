<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\XfilCookie;


class InboundController extends Controller
{

    public function __invoke(Request $request, Subscription $subscription)
    {
        $subscription->addClick();
        $cookie = Cookie::get('XFIL');
        if ($cookie){
            $subs = explode(";", $cookie);
            if(array_search($subscription->uuid, $subs) === false){
                array_push($subs, $subscription->uuid);
            }
            Cookie::queue('XFIL', implode(';', $subs));
        }
        else{
            Cookie::queue('XFIL', $subscription->uuid);
        }
        return redirect($subscription->program->link, 302);
    }

}
