<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['body', 'userId', 'image', 'like', 'tag'];
    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }
    public function likes()
    {
        return $this->hasMany('App\Like', 'postId');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag', 'postId');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'postId');
    }
    public function userComments()
    {
        // return $this->hasManyThrough('App\User', 'App\Like', 'postId', 'id', 'id', 'userId');
        return $this->hasManyThrough('App\User', 'App\Comment', 'postId', 'id', 'id', 'userId');

    }
    public function userLikes()
    {
        // return $this->hasManyThrough('App\User', 'App\Like', 'postId', 'id', 'id', 'userId');
        return $this->hasManyThrough('App\User', 'App\Like', 'postId', 'id', 'id', 'userId');

    }
}
