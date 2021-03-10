<?php

namespace App\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CharacteristicsWaters extends Model
{
    protected $table = 'chemicil_waters';

	public function post_list()
	{
		return $this->belongsTo(ListPosts::class, 'list_posts_id', 'id');
	}

	public function chimicil_list()
	{
		return $this->belongsTo(Chemicals::class, 'chemicals_id', 'id');
	}

	public function users()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
