<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class user extends Model
{
    use Notifiable;
    protected $table ='users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username' , 'email' , 'password' , 'profile' , 'active' , 'private'
    ];

    protected $hidden =[
         'remember_token'
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser','user_id');
    }


    public function friends()
    {
        return $this->hasMany('App\models\friend' ,'user_id_self' ,'username');
    }

    public function likes()
    {
        return $this->hasMany('App\models\like' ,'username' ,'username');
    }

    public function friends2()
    {
        return $this->hasMany('App\models\friend' ,'user_id_friend' ,'username');
    }

    public function posts()
    {
        return $this->hasMany('App\models\post' ,'user_username' ,'username');
    }

    public function notifications()
    {
        return $this->hasMany('App\models\notification' ,'from_username' ,'username');
    }

    public function notifications2()
    {
        return $this->hasMany('App\models\notification' ,'to_username' ,'username');
    }




}
