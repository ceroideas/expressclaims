<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfManagement extends Model
{
    //
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function images()
    {
    	return $this->hasMany('App\SelfManagementImage');
    }
    public function documents()
    {
    	return $this->hasMany('App\SelfManagementDocument');
    }
}
