<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $table = 'categories';

    public function fora()
    {
        return $this->hasMany('App\Forum', 'category_id', 'id');
    }

}
