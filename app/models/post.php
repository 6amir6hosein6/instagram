<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{

    protected $fillable = ['caption' ,'media' , 'user_username' ,'like'];


    public function user()
    {
        return $this->belongsTo('App\models\user','user_username','username');
    }

    public function likes()
    {
        return $this->hasMany('App\models\like' ,'media' ,'media');
    }
}
