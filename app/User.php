<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
class User extends Authenticatable
{
    use HasApiTokens,SoftDeletes, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'email', 'password','user_name','active', 'activation_token','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','activation_token',
    ];

    public function getAvatarAttribute($avatar)
    {
        if (!$avatar|| starts_with($avatar, 'http')) {
            return $avatar;
        }
        return URL::to('/').$avatar;
    }

    public function subcripciones()
    {
        return $this->belongsToMany(Serie::class,'suscriptors', 'user_id', 'serie_id');
    }
}
