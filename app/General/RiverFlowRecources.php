<?php

namespace App\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RiverFlowRecources extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
