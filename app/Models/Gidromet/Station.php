<?php

namespace App\Models\Gidromet;

use Illuminate\Database\Eloquent\Model;
use App\Gidromet\GidrometWaterbodyType;
use App\Gidromet\SampleStation;

class Station extends Model
{
    protected $guarded = [];

    /*public function waterbody_type() {
    	return $this->belongsTo(GidrometWaterbodyType::class, 'waterbodytype_id');
    }

    public function sample_station() {
    	return $this->belongsTo(SampleStation::class, 'station_id');
    }

    public function datas()
    {
        return $this->hasMany('App\Gidromet\GidrometData', 'station_id', 'id');
    }*/
}
