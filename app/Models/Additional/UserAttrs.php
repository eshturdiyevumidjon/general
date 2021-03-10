<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class UserAttrs extends Model
{
	protected $table = 'user_attrs';
	
    public function minvodxoz_section()
    {
	    return $this->belongsTo(Divisions::class,'minvodxoz_division_id', 'id');
    }
}
