<?php

namespace App\Transformers;

use App\Models\Subscription;

class SubscriptionTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['program','user'];

    public function transform(Subscription $subscription)
    {
        return [
            'id'   => $subscription->id,
            'uuid' => (string)$subscription->uuid,
            'clicks' => (int)$subscription->clicks,
            'sales' => (int)$subscription->sales()->count(),
            'revenue' => sprintf('%.2f',$subscription->revenue)
        ];
    }

    public function  includeProgram($subscription)
    {
        return $this->item($subscription->program, new ProgramTransformer);
    }

    public function  includeUser($subscription)
    {
        return $this->item($subscription->user, new AffiliateTransformer);
    }

}
