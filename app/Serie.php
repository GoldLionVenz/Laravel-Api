<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
class Serie extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function seasons(){
        return $this->hasMany(Season::class)->orderBy('number_season');
    }

    public function getPosterAttribute($poster)
    {
        if (!$poster || starts_with($poster, 'http')) {
            return $poster;
        }
        return URL::to('/').''.$poster;
    }
    
    public function scopeLatestSeasons(){
        return $this->seasons()->toArray();
    }
}
