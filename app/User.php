<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function posts()
    {
       return $this->hasMany('App\Post','userId');
    }
    
    public function friends()
    {
        return $this->belongsToMany('App\User','friend_user', 'userId', 'friendId', 'id', 'id');

    }

    public function myfriends()
    {
        return $this->belongsToMany('App\User','friend_user', 'friendId', 'userId', 'id', 'id');

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];
}
