<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function req()
    {
    	return $this->hasMany('App\Reservation','customer_id','user_id');
    }
    public function requests()
    {
    	return Reservation::where('customer_id',$this->user_id)->where('status',0)->count();
    }

    public function generalStatus()
    {
        if ($this->user->lastSinister()) {
            $i = Record::where('reservation_id',$this->user->lastSinister()->id)->first();
            $v = Image::where('reservation_id',$this->user->lastSinister()->id)->first();
            if ($i || $v) {
                return 'Aperto';
            }
            return 'Fatto';
        }else if($this->user->lastSinisterClose()) {
            $i = Record::where('reservation_id',$this->user->lastSinisterClose()->id)->first();
            $v = Image::where('reservation_id',$this->user->lastSinisterClose()->id)->first();
            if ($i || $v) {
                return 'Chiuso';
            }
            return 'Chiuso non fatto';
        }
        
    }
}
