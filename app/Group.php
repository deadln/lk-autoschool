<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "group";
    public $timestamps = false;

    public function get_users_info()
    {
    	return $this->hasMany(UsersInfo::class, 'users_group');
    }

    public function get_office()
    {
    	return $this->belongsTo(Offices::class, 'offices_id');
    }
}
