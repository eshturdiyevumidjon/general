<?php

namespace App\Models\Minvodxoz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Information extends Model
{
    protected $fillable = ['parent_id','form_id','date','value','gvk_object_id', 'average'];

    public function form(): HasMany
    {
        return $this->hasMany (NewFormsModel::class,'id','form_id');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo (GvkObject::class,'gvk_object_id','id')->orderBy ('number');
    }

    public function objects(): HasMany
    {
        return $this->hasMany (GvkObject::class,'id','gvk_object_id');
    }

    public function getDateName()
    {
    	$month = date('m', strtotime($this->date) );
    	$year = date('Y', strtotime($this->date) );
    	if($month == 1) return 'Январь-' . $year;
    	if($month == 2) return 'Февраль-' . $year;
    	if($month == 3) return 'Март-' . $year;
    	if($month == 4) return 'Апрель-' . $year;
    	if($month == 5) return 'Май-' . $year;
    	if($month == 6) return 'Июнь-' . $year;
    	if($month == 7) return 'Июль-' . $year;
    	if($month == 8) return 'Август-' . $year;
    	if($month == 9) return 'Сентябрь-' . $year;
    	if($month == 10) return 'Октябрь-' . $year;
    	if($month == 11) return 'Ноябрь-' . $year;
    	if($month == 12) return 'Декабрь-' . $year;
    }

    public static function findObject($object)
    {
        $model = GvkObject::where([/*'id' => $object['id'], */'number' => $object['number'], 'name' => $object['name'] ])->first();
        if($model == null){

            $model = new GvkObject();
            $model->number = $object['number'];
            $model->name = $object['name'];
            $model->form_id = $object['form_id'];
            $model->unit_id = $object['unit_id'];
            $model->type_id = $object['type_id'];
            $model->get = $object['get'];
            $model->set = $object['set'];
            $model->obj_id = $object['obj_id'];
            $model->name_ru = $object['name_ru'];
            if($model->save()) return $model;

            return null;
        }
        else return $model;
    }

    public static function setDatas($datas, $year, $month)
    {
        $oldDatas = Information::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        foreach ($datas as $day => $dayValue) {
            $dataNow = date('Y-m-d', strtotime(str_replace('_', '-', $day)));
            foreach ($dayValue as $objectDayValue) {

                $model = $oldDatas->filter(function ($item) use ($dataNow, $objectDayValue) {
                    return $item->date == $dataNow && $item->gvk_object_id == $objectDayValue['object_id'];
                })->first();

                if($model == null) {
                    $model = new Information();
                    $model->form_id = $objectDayValue['formId'];
                    $model->gvk_object_id = $objectDayValue['object_id'];
                    $model->parent_id = $objectDayValue['parentId'];
                    $model->date = $objectDayValue['dateCr'];
                    $model->value = $objectDayValue['present'];
                    $model->average = $objectDayValue['morning'];
                    $model->save();
                }
                else{
                    if(!($model->value == $objectDayValue['present'] && $model->average == $objectDayValue['morning'])){
                        $model->value = $objectDayValue['present'];
                        $model->average = $objectDayValue['morning'];
                        $model->save();
                    }
                }
            }
        }
    }

    public static function setOperSirdDatas($datas, $year, $month)
    {
        $oldDatas = Information::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with('object')
            ->get();

        foreach ($datas['result'] as $dayValue) {

            $model = $oldDatas->filter(function ($item) use ($dayValue) {
                return  $item->date == $dayValue['date'] &&
                        $item->object->number == $dayValue['object']['number'] &&
                        $item->object->name == $dayValue['object']['name'];
            })->first();

            if($model == null) {
                //dd($dayValue);
                $newObject = self::findObject($dayValue['object']);

                $model = new Information();
                $model->date = $dayValue['date'];
                $model->value = $dayValue['value'];
                $model->average = $dayValue['average'];
                $model->form_id = $dayValue['form_id'];
                $model->gvk_object_id = $newObject->id;
                $model->form_id = $dayValue['form_id'];
                $model->save();
            }
            else{
                if(!($model->value == $dayValue['value'] && $model->average == $dayValue['average'])){
                    $model->value = $dayValue['value'];
                    $model->average = $dayValue['average'];
                    $model->save();
                }
            }
        }
    }

    public static function setOperAmuDatas($datas, $year, $month)
    {
        $oldDatas = Information::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with('object')
            ->get();

        foreach ($datas['result'] as $dayValue) {

            $model = $oldDatas->filter(function ($item) use ($dayValue) {
                return  $item->date == $dayValue['date'] &&
                        $item->object->number == $dayValue['object']['number'] &&
                        $item->object->name == $dayValue['object']['name'];
            })->first();

            if($model == null) {
                //dd($dayValue);
                $newObject = self::findObject($dayValue['object']);

                $model = new Information();
                $model->date = $dayValue['date'];
                $model->value = $dayValue['value'];
                $model->average = $dayValue['average'];
                $model->form_id = $dayValue['form_id'];
                $model->gvk_object_id = $newObject->id;
                $model->form_id = $dayValue['form_id'];
                $model->save();
            }
            else{
                if(!($model->value == $dayValue['value'] && $model->average == $dayValue['average'])){
                    $model->value = $dayValue['value'];
                    $model->average = $dayValue['average'];
                    $model->save();
                }
            }
        }
    }
}
