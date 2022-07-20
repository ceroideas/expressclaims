<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfManagementImage extends Model
{
    //
    public function self_management()
    {
    	return $this->belongsTo('App\SelfManagement');
    }
}
