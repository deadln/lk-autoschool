<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    public $timestamps = false;

    public function get_instructors_name()
    {
    	return $this->belongsTo(Users::class, 'instructors_id');
    }
}
