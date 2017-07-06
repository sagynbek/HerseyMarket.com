<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    
    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }

    public function likes()
    {
    	return $this->hasMany('App\Like');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function l2_category()
    {
        return $this->belongsTo('App\L2_Category');
    }

    public function city()
    {   
        return $this->belongsTo('App\City');
    }

    public function province()
    {   
        return $this->belongsTo('App\Province');
    }
}
