<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{

    protected $fillable = ['username','media'];

    public function media()
    {
        return $this->belongsTo('App\models\post','media','media');
    }


    public function user()
    {
        return $this->belongsTo('App\models\user','username','username');
    }
}
