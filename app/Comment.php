<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['postId', 'userId', 'body'];
    protected $with='user';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
