<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the user's comments,favorites and likes.
     */

     public function groups(){
         return $this->hasMany('App\Group','writtenBy','id');
     }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }
    public function likes()
    {
        return $this->hasMany('App\Like','user_id','id');
    }
    public function notifications(){
        return $this->hasMany('App\Notification','receiver_id','id');
    }
    public function role(){
        return $this->belongsTo('App\RoleUser', 'role_id','id');
    }

    public function accessTokens()
    {
        return $this->hasMany(OauthAccessToken::class);
    }
}
