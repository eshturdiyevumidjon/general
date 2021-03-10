<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
    	'name'
    ];
}
