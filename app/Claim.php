<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $casts = [
        "json_information" => "array"
    ];
    //
    public function claims()
    {
    	return $this->hasMany('App\Claim');
    }

    public function parent()
    {
        return $this->belongsTo('App\Claim','claim_id','id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function _supervisor()
    {
    	return $this->belongsTo('App\User','supervisor','id');
    }
}
