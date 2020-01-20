<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramReward extends Model
{
    protected $fillable = [
        'percentage',
        'program_id',
    ];

    public function program()
    {
        return $this->belongsTo('App\Models\Program');
    }

}
