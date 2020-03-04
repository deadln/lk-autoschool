<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    protected $table = "users_info";
    public $timestamps = false;

    public function get_users()
    {
    	return $this->belongsTo(Users::class, 'users_id');
    }
}
