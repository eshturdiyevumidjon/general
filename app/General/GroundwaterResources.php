<?php

namespace App\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class GroundwaterResources extends Model
{
	public function users()
	{
		return $this->belongsTo(User::class,'user_id');

	}
}
