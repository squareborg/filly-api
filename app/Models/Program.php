<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Services\MediaService;
use App\Models\ProgramMedia;

use Webpatser\Uuid\Uuid;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'link',
        'name',
        'description',
        'approved',
        'rejected',
        'rejected_reason',
        'program_category_id'
    ];

    protected $appends = [
        'clicks'
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

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ProgramCategory()
    {
        return $this->belongsTo('App\Models\ProgramCategory');
    }

    public function subscribers()
    {
        return $this->belongsToMany('App\Models\User', 'subscriptions', 'program_uuid', 'user_id', 'uuid', 'id');
    }

    public function getSubscribedAttribute()
    {
        if (auth()->user()){
            if (auth()->user()->subscriptions->where('program_uuid', $this->uuid)->count()){
                return true;
            }
        }
        return false;
    }

    public function getSubscribedUUIDAttribute()
    {
        if (auth()->user()){
            $sub = auth()->user()->subscriptions->where('program_uuid', $this->uuid)->first();
            if ($sub){
                return $sub->uuid;
            }
        }
        return false;
    }

    public function getClicksAttribute()
    {
        return $this->subscribers()->sum('clicks');
    }

    public function sales()
    {
        return $this->hasManyThrough(
            'App\Models\Sale',
            'App\Models\Subscription',
            'program_uuid',
            'subscription_id',
            'uuid',
            'id');
    }

    public function media()
    {
        return $this->hasMany('App\Models\ProgramMedia', 'program_uuid', 'uuid');

    }

    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');

    }

    public function addMedia($image)
    {
        $media = new ProgramMedia;
        $media->file_extension = $image->extension();
        $media->program_uuid = $this->uuid;
        $mediaService = new MediaService();
        $media->save();
        if($mediaService->storeProgramMedia($media->uuid.'.'.$media->file_extension, $image)){

            return $media->uuid;
        }
        $media->delete();
        return false;

    }

    public function programRewards()
    {
        return $this->hasMany('App\Models\ProgramReward');
    }

    public function getProgramRewardAttribute()
    {
        return $this->programRewards()->latest()->first();
    }

    public function scopeAvailable($query)
    {
        $nwQuery =  $query->whereIn('merchant_id', Auth::user()->merchantSubscriptions->pluck('merchant_id'));
    }

}
