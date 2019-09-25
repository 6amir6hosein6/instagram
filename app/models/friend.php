<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class friend extends Model
{
    protected $fillable = ['user_id_self' , 'user_id_friend'];
    protected $table ='friends';



    public function user()
    {
        return $this->belongsTo('App\models\user','user_id_self','username');
    }


    public function user2()
    {
        return $this->belongsTo('App\models\user','user_id_friend','username');
    }
}
