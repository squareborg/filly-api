<?php

namespace App\Actions;

use App\Models\Merchant;
use App\Models\MerchantSubscription;
use App\Notifications\MerchantSubscriptionRequest;

final class SubscribeToMerchantAction
{
    public function __invoke($merchant): Merchant
    {
        $subscription = MerchantSubscription::onlyTrashed()->where(
            [
                'affiliate_id' => auth()->user()->id,
                'merchant_id' => $merchant->id
            ]
        )->first();

        if ($subscription) {
            $subscription->restore();
        } else {
            $subscription = MerchantSubscription::firstOrCreate(
                [
                    'affiliate_id' => auth()->user()->id,
                    'merchant_id' => $merchant->id
                ],
                [
                    'affiliate_id' => auth()->user()->id,
                    'merchant_id' => $merchant->id,
                    'approved' => $merchant->auto_approve_affiliates ?? false
                ]);

                if ($subscription->wasRecentlyCreated && $subscription->approved === false){
                    $merchant->user->notify(new MerchantSubscriptionRequest());
                }
        }

        return $subscription->merchant;
    }
}
