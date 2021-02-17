<?php

namespace App\General;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WaterUseVariousNeeds extends Model
{
	public function users()
	{
		return $this->belongsTo(User::class,'user_id');

	}
}
