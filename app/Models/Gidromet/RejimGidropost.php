<?php

namespace App\Models\Gidromet;

use Illuminate\Database\Eloquent\Model;

class RejimGidropost extends Model
{
    protected $table = 'rejim_gidropost';
	public $timestamps = false;

    protected $fillable = [
    	'station_id', 'year', 'parameter_id',
    	'january', 'february', 'march',
    	'april', 'may', 'june',
    	'july', 'august', 'september',
    	'october', 'november', 'decamber',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function parameter()
    {
        return $this->belongsTo(GidrometParameter::class);
    }

    public static function findGidrometParameter($parameters, $data)
    {
        $parameter_id = null;
        foreach ($parameters as $pr) {
            if($pr->param_id == $data['parameter']['param_id'] && $pr->param_name == $data['parameter']['param_name']){
                $parameter_id = $pr->id;
                break;
            }
        }
        if($parameter_id == null){
            $prNew = new GidrometParameter();
            $prNew->param_id = $data['parameter']['param_id'];
            $prNew->param_name = $data['parameter']['param_name'];
            $prNew->save();
            $parameter_id = $prNew->id;
        }

        return $parameter_id;
    }

    public static function findStation($stations, $data)
    {
        $station_id = null;
        foreach ($stations as $station) {
            if( $station->station_code == $data['station']['station_code'] && 
                $station->station_name == $data['station']['station_name'] && 
                $station->station_id == $data['station']['station_id']) {
                $station_id = $station->id;
                break;
            }
        }
        if($station_id == null){
            //$newStation = Station::create($data['station']);
            $newStation = new Station();
            $newStation->station_code = $data['station']['station_code'];
            $newStation->order_number = $data['station']['order_number'];
            $newStation->waterbodytype_id = $data['station']['waterbodytype_id'];
            $newStation->station_name = $data['station']['station_name'];
            $newStation->station_id = $data['station']['station_id'];
            $newStation->ugm = $data['station']['ugm'];
            $newStation->pool_squire = $data['station']['pool_squire'];
            $newStation->height_system = $data['station']['height_system'];
            $newStation->source_distance = $data['station']['source_distance'];
            $newStation->location = $data['station']['location'];
            $newStation->cadastre_id = $data['station']['cadastre_id'];
            $newStation->river_name = $data['station']['river_name'];
            $newStation->latitude = $data['station']['latitude'];
            $newStation->longitude = $data['station']['longitude'];
            $newStation->station_zero_height = $data['station']['station_zero_height'];
            $newStation->save();
            $station_id = $newStation->id;
        }

        return $station_id;
    }

    public static function setDatas($datas, $year)
    {
        $parameters = GidrometParameter::get();
        $stations = Station::get();

    	foreach ($datas as $data) {

            if($data['gidromet_average'] != null) {
                $parameter_id = self::findGidrometParameter($parameters, $data);
                $station_id = self::findStation($stations, $data);
        		$average = $data['gidromet_average'];
        		$model = RejimGidropost::where([
                    'year' => $year, 
                    'station_id' => $data['station_id'], 
                    'parameter_id' => $data['parameter_id']
                ])->first();

        		if($model == null) $model = new RejimGidropost();
        		//dd($average);
        		$model->year = $year;
        		$model->station_id = $station_id;
        		$model->parameter_id = $parameter_id;
        		$model->january = (float)$average['I'];
        		$model->february = (float)$average['II'];
        		$model->march = (float)$average['III'];
        		$model->april = (float)$average['IV'];
        		$model->may = (float)$average['V'];
                $model->june = (float)$average['VI'];
                $model->july = (float)$average['VII'];
                $model->august = (float)$average['VIII'];
                $model->september = (float)$average['IX'];
                $model->october = (float)$average['X'];
                $model->november = (float)$average['XI'];
        		$model->decamber = (float)$average['XII'];
        		$model->save();
            }
    	}
    }

}
