<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class Metki extends Model
{

  protected $guarded = [];

  public function language()
  {
  	return $this->belongsTo(Language::class, 'group_id');
  }
}
