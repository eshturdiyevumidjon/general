<?php

namespace App\Models\Gidrogeologiya;

use Illuminate\Database\Eloquent\Model;

class GidrogeologiyaWellData extends Model
{
    protected $table = 'gidrogeologiya_well_data';
	public $timestamps = false;

    protected $fillable = [
    	'wells_type_id', 'type_name', 'year', 'number_auther', 'cadaster_number', 'mineralization'
    ];

    public static function setDatas($datas, $year)
    {
        $oldDatas = GidrogeologiyaWellData::where('year', $year)->get();

    	foreach ($datas as $data) {

            $model = $oldDatas->filter(function ($item) use ($year, $data) {
                return $item->year == $year && 
                    $item->wells_type_id == $data['wells_type_id'] && 
                    $item->number_auther == $data['number_auther'] && 
                    $item->cadaster_number == $data['cadaster_number'];
            })->first();

    		if($model == null) $model = new GidrogeologiyaWellData();

    		$model->year = $year;
    		$model->wells_type_id = $data['wells_type_id'];
            $model->type_name = $data['type_name'];
    		$model->number_auther = $data['number_auther'];
    		$model->cadaster_number = $data['cadaster_number'];
    		$model->mineralization = (float)$data['mineralization'];
    		$model->save();
        }
    }

}
