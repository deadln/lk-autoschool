<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class Api extends Controller
{
    public function userGet(Request $request)
    {
    	$quest = $request->q; 
    	return Users::where('name', 'LIKE', $quest.'%')->where('role', '=', 'student')->get()->toJson();
    }
}
