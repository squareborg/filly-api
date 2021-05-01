<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MerchantSubscription extends Pivot
{
    use SoftDeletes;

    protected $table = 'merchant_subscriptions';

    protected $fillable = [
        'affiliate_id',
        'merchant_id',
        'approved',
        'rejected',
        'rejected_reason'
    ];

    protected $casts = ['approved' => 'boolean', 'rejected' => 'boolean'];

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

    public function affiliate()
    {
        return $this->belongsTo('App\Models\User', 'affiliate_id', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant', 'merchant_id', 'id');
    }



}
