<?php

namespace App\Models\Minvodxoz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Information;

class GvkObject extends Model
{
    protected $fillable = ['name','form_id','unit_id','number','type_id', 'get', 'set', 'obj_id', 'name_ru'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(NewFormsModel::class,'form_id','id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(GvkObjectType::class,'type_id','id');
    }

    public function units(): HasMany
    {
        return $this->hasMany (Unit::class,'id','unit_id');
    }

    public function getUnitName($unitList)
    {
        foreach ($unitList as $value) {
            if($value->id == $this->unit_id) return $value->name;
        }
        return "";
    }

    public function information(): HasMany
    {
        return $this->hasMany(Information::class,'gvk_object_id','id')->orderBy('date','asc');
    }

    public function informationBelong()
    {
        return $this->hasMany(Information::class,'gvk_object_id','id')->orderBy('date','asc');
    }

    public function getDateName($year, $month)
    {
        /*$month = date('m', strtotime($this->date) );
        $year = date('Y', strtotime($this->date) );*/
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

    public function getMonthName($month)
    {
        if($month == 1) return 'january';
        else if($month == 2) return 'february';
        else if($month == 3) return 'march';
        else if($month == 4) return 'april';
        else if($month == 5) return 'may';
        else if($month == 6) return 'june';
        else if($month == 7) return 'july';
        else if($month == 8) return 'august';
        else if($month == 9) return 'september';
        else if($month == 10) return 'october-';
        else if($month == 11) return 'november';
        else if($month == 12) return 'decamber';
    }
}
