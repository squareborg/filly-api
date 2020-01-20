<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Merchant;

class MerchantTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['programs', 'user', 'stats'];



    public function transform(Merchant $merchant)
    {
        return [
            'uuid' => $merchant->uuid,
            'name' => $merchant->name,
            'logo_image_url' => $merchant->logoImageUrl,
            'user_is_subscribed' => $merchant->userIsSubscribed,
            'subscription_status' => $merchant->subscriptionStatus,
            'auto_approve_affiliates' => $merchant->auto_approve_affiliates,
            'merchant_reward' => $merchant->merchantReward->percentage ?? null,
            'category' => $merchant->category ? $merchant->category->name : null,
        ];
    }

    public function includePrograms(Merchant $merchant)
    {
        return $this->collection($merchant->programs, new ProgramTransformer());
    }

    public function includeUser(Merchant $merchant)
    {
        return $this->item($merchant->user, new UserTransformer());
    }

    public function includeStats(Merchant $merchant)
    {
        return $this->primitive([
            'clicks' => $merchant->clicks,
            'sales' => $merchant->salesCount,
        ]);
    }
}
