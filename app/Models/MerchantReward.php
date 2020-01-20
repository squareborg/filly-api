<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantReward extends Model
{
    protected $fillable = [
        'percentage',
        'merchant_id',
    ];

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }

}
