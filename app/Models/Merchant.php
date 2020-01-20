<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class Merchant extends Model
{

    protected $fillable = ['user_id', 'logo', 'name', 'description', 'auto_approve_affiliates'];

    protected $appends = ['logoImageUrl'];

    protected $casts = ['user_is_subscribed' => 'boolean', 'auto_approve_affiliates' => 'boolean'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function getLogoImageUrlAttribute()
    {
        if($this->logo){
            return $this->logo;
            return Storage::url($this->logo);
        }
        return null;
    }

    public function affiliates()
    {
        return $this->belongsToMany(User::class, 'merchant_subscriptions', 'merchant_id', 'affiliate_id')
            ->as('status')
            ->using(MerchantSubscription::class)
            ->withPivot('approved', 'rejected')
            ->withTimestamps();
    }


    // public function getUserIsSubscribedAttribute()
    // {
    //     return (bool)$this->affiliates()->where('affiliate_id', auth()->user()->id)->count();
    // }

    public function getSubscriptionStatusAttribute()
    {
        $piv = auth()->user()->merchants()->where('merchant_id', $this->id)->first();
        //$status = $this->affiliates()->where('affiliate_id', auth()->user()->id)->first();
        if(!$piv){
            return 'none';
        }
        switch($piv->status) {
        case $piv->status->approved:
            return 'approved';
            break;
        case $piv->status->rejected:
            return 'rejected';
            break;
        default:
            return 'requested';
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function merchantRewards()
    {
        return $this->hasMany('App\Models\MerchantReward');
    }

    public function getMerchantRewardAttribute()
    {
        return $this->merchantRewards()->latest()->first();
    }

    public function programs()
    {
        return $this->hasMany('App\Models\Program');
    }

    public function scopeAvailable($query)
    {
        return $query->where(
            [
                ['approved','=', true],
                ['user_has_enabled','=', true]
            ]
        );
    }


    public function getClicksAttribute()
    {
        if (!$this->programs->count()){
            return 0;
        }
        return $this->programs->reduce(function($carry, $item){return $carry + $item->clicks;});
    }

    public function getSalesCountAttribute()
    {
        if (!$this->programs->count()){
            return 0;
        }
        return $this->programs->reduce(function($carry, $item){return $carry + $item->sales()->count();});
    }

    public function category()
    {
        return $this->belongsTo(ProgramCategory::class);
    }
}

