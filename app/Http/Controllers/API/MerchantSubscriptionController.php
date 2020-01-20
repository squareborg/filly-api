<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\MerchantSubscriptionApproved;

class MerchantSubscriptionController extends Controller
{
    public function update(Request $request, MerchantSubscription $subscription)
    {
        $subscription->update($request->all());
        if( $subscription->approved) {
            $subscription->affiliate->notify(new MerchantSubscriptionApproved($subscription->merchant));
        }
        return response()->json($subscription, Response::HTTP_OK);
    }
}
