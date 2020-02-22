<?php

namespace App\Transformers;

use App\Models\MerchantSubscription;

class MerchantSubscriptionTransformer extends \League\Fractal\TransformerAbstract
{

    protected $availableIncludes = ['affiliate'];

    protected $defaultIncludes = ['affiliate'];

    public function transform(MerchantSubscription $merchantSubscription)
    {
        return [
            'approved' => $merchantSubscription->approved
        ];
    }

    public function includeAffiliate(MerchantSubscription $merchantSubscription)
    {
        return $this->item($merchantSubscription->affiliate, new AffiliateTransformer());
    }
}
