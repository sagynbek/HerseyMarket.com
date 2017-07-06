<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function users()
    {   
        return $this->hasMany('App\User');
    }
    public function provinces()
    {   
        return $this->hasMany('App\Province');
    }
    public function posts()
    {   
        return $this->hasMany('App\Post');
    }
}
