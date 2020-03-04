<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    public $timestamps = false;

    protected $visible = ['id', 'name', 'login'];

    public function get_users_info()
    {
    	return $this->hasOne(UsersInfo::class, 'users_id');
    }

    public function get_instructors_info()
    {
        return $this->hasOne(InstructorsInfo::class, 'users_id');
    }

    public function offices()
    {
    	return $this->belongsTo(Offices::class);
    }
}
