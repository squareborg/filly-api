<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Sale extends Model
{

    protected $fillable = [
        'subscription_id',
        'order_id',
        'order_total',
    ];

    protected $with = [
        'reward'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription');
    }

    public function reward()
    {
        return $this->hasOne('App\Models\SubscriptionReward');
    }

}
