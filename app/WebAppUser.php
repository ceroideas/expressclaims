<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebAppUser extends Model
{
    //
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function callDate()
    {
    	$rec = Record::where('user_id',$this->user_id)->get()->last();

    	if ($rec) {
    		return $rec->created_at->format('d-m-Y h:i:s');
    	}
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
