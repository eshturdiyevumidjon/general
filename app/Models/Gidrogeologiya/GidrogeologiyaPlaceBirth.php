<?php

namespace App\Models\Gidrogeologiya;

use Illuminate\Database\Eloquent\Model;

class GidrogeologiyaPlaceBirth extends Model
{
    protected $table = 'gidrogeologiya_place_birth';
	public $timestamps = false;

    protected $fillable = [
    	'code', 'name', 'year', 'groundwater_resource', 'selection_from_approved_groundwater_reserves', 'favcolor'
    ];

    public static function setDatas($datas, $year)
    {
        $oldDatas = GidrogeologiyaPlaceBirth::where('year', $year)->get();

    	foreach ($datas as $data) {

            $model = $oldDatas->filter(function ($item) use ($year, $data) {
                return $item->year == $year && 
                    $item->code == $data['code'] && 
                    $item->name == $data['name'];
            })->first();

    		if($model == null) $model = new GidrogeologiyaPlaceBirth();

    		$model->code = $data['code'];
            $model->name = $data['name'];
    		$model->year = $year;
    		$model->groundwater_resource = (float)$data['groundwater_resource'];
            $model->selection_from_approved_groundwater_reserves = (float)$data['selection_from_approved_groundwater_reserves'];
    		$model->favcolor = $data['favcolor'];
    		$model->save();
        }
    }

}
