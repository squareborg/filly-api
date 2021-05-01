<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Events\ProgramSale;
use Webpatser\Uuid\Uuid;

class Subscription extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'program_uuid',
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

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_uuid', 'uuid');
    }

    public function addClick()
    {
        $this->clicks++;
        $this->save();
    }

    public function sales(){
        return Sale::where('subscription_id', $this->id);
    }

    public function rewards()
    {
        return $this->hasMany('App\Models\SubscriptionReward');
    }

    public function getRevenueAttribute()
    {
        return $this->rewards->pluck('amount_gbp')->sum();
    }

    public function addSale($order_id, $order_total)
    {
        Log::debug('addSale: init');
        Log::debug("addSale: order_id: $order_id - order_total: $order_total");

        $programOrders = $this->program->sales()->where('order_id', $order_id)->first();
        if (!$programOrders) {
            Log::debug('addSale: not a duplicate sale');
            Log::debug('addSale: id $this->id');
            $sale = Sale::create(
                [
                    'order_id' => $order_id,
                    'order_total' => $order_total,
                    'subscription_id' => $this->id
                ]
            );
            event(new ProgramSale($sale));
            return true;
        } else {
            Log::debug('addSale: duplicate sale');
        }
        return false;
    }
}
