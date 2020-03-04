<?php

namespace App\Http\Controllers;
use App\Offices as offices;
use App\Users as users;
use Illuminate\Http\Request;

class OfficesController extends Controller
{
    public function index()
    {
    	$token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;
    	if($role == 'admin')
    		return view('offices',[
          'role'=>$role,
          'offices' => offices::all()
        ]);
    	else
    		return redirect('/');
    }

    public function add(Request $request){
    	
       	if($request->method() == 'POST')
       	{
       		$token = $_COOKIE['token'];
	        $user = users::where('token', $token)->first();
	        $role = $user->role;
       		switch ($role) {
       			case 'admin':
       				$item = new offices;
  				    $item->offices_name = $request->input('name'); 
		  		    $item->save();
       				return redirect('/offices');

       			default:
   					return redirect('/');
       		}
       	}

     	$token = $_COOKIE['token'];
      	$user = users::where('token', $token)->first();
      	$role = $user->role;

    	if($role == 'admin' || $role == 'manager')
    		return view('offices_add', ['role'=>$role]);
    	else
    		return redirect('/');
    	
    }

    public function edit(Request $request, $id)
    {
      if($request->method() == 'POST')
      {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;
        switch ($role) {
          case 'admin':
            $item = offices::find($id);
            $item->offices_name = $request->input('name'); 
		        $item->save();        
            return redirect('/offices');
          default:
          return redirect('/');
        }
      }
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      switch ($role) {
        case 'admin':
          $offices_edit = offices::where('id', $id)->first();           
          return view('offices_edit', [
            'role'=>$role,
            'offices_edit'=>$offices_edit,
          ]);
        default:
        return redirect('/');
      }
    	return redirect('/');
    }

    public function remove(Request $request, $id)
    {
    	if ($id == 0){
            return redirect('profile');
        }
    	$item = offices::find($id);
        $item->delete();
        return redirect('/offices');
    }
}
