<?php

namespace App\Models\Gidromet;

use Illuminate\Database\Eloquent\Model;

class GidrometParameter extends Model
{
	protected $guarded = [];

	/*public function water_temperature_detail()
	{
		return $this->hasOne(\App\Gidromet\WaterTemperatureDetail::class);
    }
    
    public function gidrometDatas()
    {
        return $this->hasMany('App\Gidromet\GidrometData', 'parameter_id', 'id');
    }*/
}
