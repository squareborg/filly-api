<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

use Webpatser\Uuid\Uuid;

class SubscriptionReward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sale_id',
        'subscription_id',
        'amount_gbp'
    ];

    protected $casts = [
        'rewarded' => 'boolean'
    ];

    public function sale()
    {
        return $this->hasOne('App\Models\Sale');
    }

    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription');
    }

}
