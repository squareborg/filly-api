<?php

namespace App\Http\Controllers\API;

use App\Models\Merchant;
use App\Http\Controllers\Controller;
use App\Actions\SubscribeToMerchantAction;
use App\Transformers\MerchantTransformer;


class MerchantSubscribeController extends Controller
{
    public function __invoke(Merchant $merchant, SubscribeToMerchantAction $subscribeToMerchantAction)
    {
        $subscription = $subscribeToMerchantAction($merchant);
        return fractal()->item($subscription)->transformWith(new MerchantTransformer);
    }
}
