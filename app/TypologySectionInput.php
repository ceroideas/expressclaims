<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypologySectionInput extends Model
{
	//
	public function options()
	{
		return $this->hasMany('App\TypologySectionInputOption');
	}
}