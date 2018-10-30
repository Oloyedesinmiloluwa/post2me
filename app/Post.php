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
}
