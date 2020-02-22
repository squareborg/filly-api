<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Webpatser\Uuid\Uuid;

class ProgramMedia extends Model
{

    protected $fillable = [
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

    public function program()
    {
        return $this->belongsTo('App\Models\Program');
    }

    public function getFilenameAttribute()
    {
        return sprintf('https://s3.eu-west-2.amazonaws.com/xfil-network-test/media/%s.%s', $this->uuid, $this->file_extension);
    }

}
