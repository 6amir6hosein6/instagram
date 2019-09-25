<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $fillable = ['from_username','to_username','kind','new','not_date'];


    public function user_from()
    {
        return $this->belongsTo('App\models\user','from_username','username');
    }


    public function user_to()
    {
        return $this->belongsTo('App\models\user','to_username','username');
    }
}
