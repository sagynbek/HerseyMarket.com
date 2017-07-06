<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post','category_id','id');
    }

    public function l2_categories()
    {
        return $this->hasMany('App\L2_Category','category_id','id');
    }
}
