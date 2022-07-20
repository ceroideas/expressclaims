<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public function from()
    {
    	return $this->belongsTo('App\User','from_id','id');
    }

    public function to()
    {
    	return $this->belongsTo('App\User','to_id','id');
    }
}
