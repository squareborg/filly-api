<?php

namespace App\Transformers;

use App\Models\Sale;

class SaleTransformer extends \League\Fractal\TransformerAbstract
{

    protected $availableIncludes = ['subscription'];

    protected $defaultIncludes = [
        'subscription'
    ];

    public function transform(Sale $sale)
    {
        return $sale->toArray();
    }

    public function includeSubscription(Sale $sale)
    {
       return $this->item($sale->subscription, new SubscriptionTransformer);

    }

}
