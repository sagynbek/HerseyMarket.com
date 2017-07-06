<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer_Category extends Model
{
    public function post()
    {
    	return $this->belongsTo('App\Post');
    }
    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
