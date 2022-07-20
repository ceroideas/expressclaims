<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimFile extends Model
{
    //
    public function claim()
    {
        
    }
    public function type()
    {
    	$claim = Claim::where('sin_number',$this->sin_number)->first();
    	if ($claim->information) {
    		$info = json_decode($claim->information,true);
    		if (isset($info['typology'])) {
    			return $info['typology'];
    		}
    		return "N / A";
    	}

    	return "N / A";
    }
}
