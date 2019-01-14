<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
class Episode extends Model
{
    //.
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function season(){
        return $this->belongsTo(Season::class);
    }

    public function getSubtitleAttribute($subtitle)
    {
        if (!$subtitle || starts_with($subtitle, 'http')) {
            return $subtitle;
        }
         return URL::to('/').''.$subtitle;
    }
    public function getVideoAttribute($video)
    {
        if (!$video || starts_with($video, 'http')) {
            return $video;
        }
         return URL::to('/').''.$video;
    }
}
