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

    public function lastSeason(){
        return $this->hasMany(Season::class)->orderBy('number_season','desc')->first();
    }

    public function getPosterAttribute($poster)
    {
        if (!$poster || starts_with($poster, 'http')) {
            return $poster;
        }
        return URL::to('/').'/storage/'.$poster;
    }
    
    public function scopeLatestSeasons(){
        return $this->seasons()->toArray();
    }
    public function subcriptores()
    {
        return $this->belongsToMany(User::class,'suscriptors', 'serie_id', 'user_id');
    }

    
}
