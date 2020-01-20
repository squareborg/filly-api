<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Merchant;
use App\Notifications\MerchantSubscriptionRequest;
class MerchantSubscribeController extends Controller
{
    public function __invoke(Request $request, Merchant $merchant)
    {
        $subscription = MerchantSubscription::onlyTrashed()->where(
            [
                'affiliate_id' => $request->user()->id,
                'merchant_id' => $merchant->id
            ]
        );

        if ($subscription->count() > 0) {
            $subscription->restore();
        }
        else{
            $subscription = MerchantSubscription::where(
                [
                    'affiliate_id' => $request->user()->id,
                    'merchant_id' => $merchant->id
                ]
            );
            if ($subscription->count() == 0) {
                $subscription = MerchantSubscription::create(
                    [
                        'affiliate_id' => $request->user()->id,
                        'merchant_id' => $merchant->id,
                        'approved' => $merchant->auto_approve_affiliates ?? false
                    ]
                );
                if ($subscription->approved === false){
                    $merchant->user->notify(new MerchantSubscriptionRequest());
                }
            }

        }

        return response()->json([$subscription,
            'message' => 'Subscribed'
        ], 200);
    }
}
