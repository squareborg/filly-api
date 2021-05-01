<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    protected $appends = [
        'full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_subscriptions', 'affiliate_id')
            ->as('status')
            ->using(MerchantSubscription::class)
            ->withPivot('approved', 'rejected')
            ->withTimestamps();
    }

    public function merchantSubscriptions()
    {
        return $this->hasMany('App\Models\MerchantSubscription', 'affiliate_id');
        //return $this->belongsToMany('App\Models\Program', 'subscriptions', 'user_id', 'program_id');
    }


    public function confirmationTokens()
    {
        return $this->hasMany('App\Models\ConfirmationToken');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
        //return $this->belongsToMany('App\Models\Program', 'subscriptions', 'user_id', 'program_id');
    }

    public function getClicksAttribute()
    {
        return $this->subscriptions()->sum('clicks');
    }

    public function sales()
    {
        return $this->hasManyThrough(
            'App\Models\Sale',
            'App\Models\Subscription',
            'user_id',
            'subscription_id',
            'id',
            'id');
    }

    public function getSalesCountAttribute()
    {
        return $this->sales->count();
    }

    public function programs()
    {
        return $this->hasManyThrough('App\Models\Program', 'App\Models\Merchant');
    }

    public function getMerchantProfile()
    {
        if (!$this->merchant) {
            Merchant::create(['user_id' => $this->id]);
        }
        return $this->merchant;
    }

    public function merchant()
    {
        return $this->hasOne('App\Models\Merchant');
    }

    public function availablePrograms()
    {
        return Program::whereIn('merchant_id', $this->merchantSubscriptions->pluck('id')->all())->get();
    }


    public function getFullNameAttribute()
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
    }
}
