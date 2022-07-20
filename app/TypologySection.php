<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypologySection extends Model
{
	//
	public function inputs()
	{
		return $this->hasMany('App\TypologySectionInput')->orderBy('order','desc');
	}
}