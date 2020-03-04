<?php

namespace App\Http\Controllers;
use App\Users as users;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(){
    	$token = $_COOKIE['token'];
		$user = users::where('token', $token)->first();
		$role = $user->role;
		if ($role == 'admin')
    		return view('statistic',['role'=>$role]);
    	else
    		return redirect('/');
    }
}
