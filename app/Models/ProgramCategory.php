<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Program;

class ProgramCategory extends Model
{
    use HasSlug;

    protected $fillable = [
        'name'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Models\Program');
    }


}
