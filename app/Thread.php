<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public $table = 'threads';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function forum()
    {
        return $this->belongsTo('App\Forum', 'forum_id');
    }

    public function posts()
    {
        return $this->belongsTo('App\Post', 'thread_id', 'id');
    }
}
