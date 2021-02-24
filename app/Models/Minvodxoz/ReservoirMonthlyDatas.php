<?php

namespace App\Models\Minvodxoz;

use Illuminate\Database\Eloquent\Model;

class ReservoirMonthlyDatas extends Model
{
    protected $table = 'reservoir_monthly_datas';
	public $timestamps = false;

    protected $fillable = [
    	'object_id', 'year',
    	'january_1', 'january_2', 'january_3',
    	'february_1', 'february_2', 'february_3',
    	'march_1', 'march_2', 'march_3',
    	'april_1', 'april_2', 'april_3',
    	'may_1', 'may_2', 'may_3',
    	'june_1', 'june_2', 'june_3',
    	'july_1', 'july_2', 'july_3',
    	'august_1', 'august_2', 'august_3',
    	'september_1', 'september_2', 'september_3',
    	'october_1', 'october_2', 'october_3',
    	'november_1', 'november_2', 'november_3',
    	'decamber_1', 'decamber_2', 'decamber_3',
    ];

    public function object(): BelongsTo
    {
        return $this->belongsTo(GvkObject::class,'gvk_object_id','id')->orderBy('number');
    }

    public static function setDatas($datas, $year)
    {
    	foreach ($datas as $data) {
    		$object_datas = $data['object_datas'];
    		//dd($object_datas);
    		$model = ReservoirMonthlyDatas::where(['year' => $year, 'object_id' => $data['object_id']])->first();
    		if($model == null) $model = new ReservoirMonthlyDatas();
    		
    		$model->object_id = $data['object_id'];
    		$model->year = $year;
    		$model->january_1 = $object_datas['january_1'];
    		$model->january_2 = $object_datas['january_2'];
    		$model->january_3 = $object_datas['january_3'];
    		$model->february_1 = $object_datas['february_1'];
    		$model->february_2 = $object_datas['february_2'];
    		$model->february_3 = $object_datas['february_3'];
    		$model->march_1 = $object_datas['march_1'];
    		$model->march_2 = $object_datas['march_2'];
    		$model->march_3 = $object_datas['march_3'];
    		$model->april_1 = $object_datas['april_1'];
    		$model->april_2 = $object_datas['april_2'];
    		$model->april_3 = $object_datas['april_3'];
    		$model->may_1 = $object_datas['may_1'];
    		$model->may_2 = $object_datas['may_2'];
    		$model->may_3 = $object_datas['may_3'];
    		$model->june_1 = $object_datas['june_1'];
    		$model->june_2 = $object_datas['june_2'];
    		$model->june_3 = $object_datas['june_3'];
    		$model->july_1 = $object_datas['july_1'];
    		$model->july_2 = $object_datas['july_2'];
    		$model->july_3 = $object_datas['july_3'];
    		$model->august_1 = $object_datas['august_1'];
    		$model->august_2 = $object_datas['august_2'];
    		$model->august_3 = $object_datas['august_3'];
    		$model->september_1 = $object_datas['september_1'];
    		$model->september_2 = $object_datas['september_2'];
    		$model->september_3 = $object_datas['september_3'];
    		$model->october_1 = $object_datas['october_1'];
    		$model->october_2 = $object_datas['october_2'];
    		$model->october_3 = $object_datas['october_3'];
    		$model->november_1 = $object_datas['november_1'];
    		$model->november_2 = $object_datas['november_2'];
    		$model->november_3 = $object_datas['november_3'];
    		$model->decamber_1 = $object_datas['decamber_1'];
    		$model->decamber_2 = $object_datas['decamber_2'];
    		$model->decamber_3 = $object_datas['decamber_3'];
    		$model->save();
    	}
    }

}
