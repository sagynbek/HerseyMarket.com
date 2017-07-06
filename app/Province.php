<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    
    public function city()
    {   
        return $this->belongsTo('App\City');
    }

    public function users()
    {   
        return $this->hasMany('App\User');
    }
    public function posts()
    {   
        return $this->hasMany('App\Post');
    }
    
}
