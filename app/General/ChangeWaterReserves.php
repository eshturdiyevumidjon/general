<?php

namespace App\General;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChangeWaterReserves extends Model
{
	public function users()
	{
		return $this->belongsTo(User::class,'user_id');

	}
}
