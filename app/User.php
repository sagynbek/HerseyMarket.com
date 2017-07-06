<?php
namespace App; 
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    
    //use \Illuminate\Auth\Authenticatable;
    
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function notifications()
    {   
        return $this->hasMany('App\Notification','receiver_id');
    }

    public function messages()
    {   
        return $this->hasMany('App\Message','to_user_id');
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