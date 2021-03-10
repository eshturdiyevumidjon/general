<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;
//use Spatie\Permission\Traits\HasRoles;
use App\Models\Additional\Level;
use App\Models\Additional\UserAttrs;
use App\Models\Additional\Roles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    //use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class,'level_id', 'id');
    }

    public function user_attr()
    {
        return $this->hasMany(UserAttrs::class,'user_id');
    }

    public function getFullname()
    {
        return $this->lastname.' '.$this->firstname.' '.$this->middlename;
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }

    public function getUserTypeName()
    {
        if($this->user_type == 'gidromet') return 'Гидромет';
        if($this->user_type == 'general') return 'Единый Водный Кадастр';
        if($this->user_type == 'gidrogeologiya') return 'Гидрогеология';
        if($this->user_type == 'minvodxoz') return 'Минводхоз';

        return '';
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }
}
