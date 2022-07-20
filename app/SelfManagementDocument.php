<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfManagementDocument extends Model
{
    //
    public function self_management()
    {
    	return $this->belongsTo('App\SelfManagement');
    }
}
