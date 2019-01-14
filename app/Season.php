<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
class Season extends Model
{
    //
    protected $guarded = [];

    public function serie(){
        return $this->belongsTo(Serie::class);
    }
    public function getPosterAttribute($poster)
    {
        if (!$poster || starts_with($poster, 'http')) {
            return $poster;
        }
         return URL::to('/').''.$poster;
    }
    public function getBannerAttribute($banner)
    {
        if (!$banner || starts_with($banner, 'http')) {
            return $banner;
        }
         return URL::to('/').''.$banner;
    }
    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
