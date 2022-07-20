<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class MapInformation extends Model
{
    protected $appends = ['sinisters'];

    public function diferents()
    {
            return $this->hasMany('App\MapInformation','latlng','latlng')->where(function($q){
                if (session('perito2')) {
                    $q->where('SOPRALLUOGO',session('perito2'))
                    ->orWhere('SOPRALLUOGO',"");
                }
            })->where('Stato','000APERTA')->where('status',1)->whereIn('type',[1])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro');
    }

    public function getSinistersAttribute()
    {
        return MapInformation::where('Stato','000APERTA')->where('latlng',$this->latlng)->where('status',1)->where('type',$this->type)->count();
    }

    public function diferentsG()
    {
        return $this->hasMany('App\MapInformation','latlng','latlng')->where('Stato','000APERTA')->where('status',1)->whereIn('type',[1,2])->select('*', DB::raw('count(N_Sinistro) as total'))->groupBy('N_Sinistro');
    }
}