<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preassign extends Model
{
    //
    public function operator()
    {
    	return $this->belongsTo('App\User');
    }
}
