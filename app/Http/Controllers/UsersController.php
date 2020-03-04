<?php

namespace App\Http\Controllers;
use App\Users as users;
use Illuminate\Http\Request;
use App\Offices as offices;
use App\InstructorsInfo as instructor_info;
use App\UsersInfo as user_info;
use App\Orders;
use App\Group;
use App\WeekShift;
include 'Array.php';


class UsersController extends Controller
{
    public function index()
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;
        if($role == 'admin' || $role == 'manager')
            return view('users',[
          'role'=>$role,
          'admins' => users::where('role', 'admin')->get(),
          'managers' => users::where('role', 'manager')->get(),
          'instructors' => users::where('role', 'instructor')->get(),
          'students' => users::where('role', 'student')->get(),
        ]);
        else
            return redirect('/');
    }

    public function NoActiveUsers()
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;
        if($role == 'admin' || $role == 'manager')
            return view('users_no_active',[
                'role'=>$role,
                'admins' => users::where('role', 'admin')->get(),
                'managers' => users::where('role', 'manager')->get(),
                'instructors' => users::where('role', 'instructor')->get(),
                'students' => users::where('role', 'student')->get(),
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
          $request->validate([
            "name"=>"required|min:5",
            "login"=>"required|email"
          ]);
       		switch ($role) {
       			case 'admin':
       				$this->create_new_user($request);
       				return view('user_create',[
                'role'=>$role,
                'name' => $request->input('name'),
                'login' => $request->input('login'),
                'role' => $request->input('role'),
                'office' => offices::where('offices_name', $request->input('offices'))->first()->offices_name,
                'pass' => $request->input('password'),
              ]);       			
       			case 'manager':
       				$this->create_new_user_mgr($request, $user->offices_id);
              return view('user_create',[
                'role'=>$role,
                'name' => $request->input('name'),
                'login' => $request->input('login'),
                'role' => $request->input('role'),
                'office' => offices::where('id', $user->offices_id)->first()->offices_name,
                'pass' => $request->input('password'),
              ]);

       			default:
   					return redirect('/');
       		}
       	}

     	$token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      $offices = offices::all();
    	if($role == 'admin')
    		return view('users_add', [
    		    'role'=>$role,
            'offices'=>$offices,
            'random_password'=>$this->generateRandomString(8),
            'groups'=>Group::all()
			]);
			if($role == "manager")
			{
					return view('users_add', [
    		    'role'=>$role,
            'offices'=>$offices,
            'random_password'=>$this->generateRandomString(8),
						'groups'=>Group::where('offices_id', $user->offices_id)->get()
					]);						
			}
    	else
    		return redirect('/');
    	
    }

    public function register_users(Request $request)
    {
    	if($request->method() == 'POST')
    	{
    		$this->create_new_user(
				$request->input('login'),
				$request->input('pass'),
				$request->input('role')
			);
    	}
    	return view('register_user');
    }

    public function create_new_user($request)
    {
    	$sold = $this->generateRandomString(10);
    	$item = new users;
      $item->name = $request->input('name');
  		$item->login = $request->input('login');
  		$item->sold = $sold;
  		$item->token = hash('md5', $request->input('login').$sold.$request->input('password'));
  		$item->role = $request->input('role');
      $item->offices_id = offices::where('offices_name', $request->input('offices'))->first()->id;
  		$item->save();
      if($request->role == "instructor")
      {
        $array = getSchudele();
        $array['name'] = $request->input('name');
        $info = new instructor_info;
        $info->users_id = $item->id;
        $info->instructors_worktime = "";
        $info->instructors_info = "";
        $info->img_instructor = "";
        $info->img_car = "";
        $info->transmission = "";
        $info->transmission = "";
        $info->number_car = "";
        $info->instructors_worktime = json_encode($array);
        $info->save();
      }elseif($request->role == "student"){
        $info = new user_info;
        $info->users_id = $item->id;
        $info->users_info = "";
        $info->users_group = 0;
        $info->save();
      }
      
  		return true;
    }

    public function create_new_user_mgr($request, $offices)
    {
      $sold = $this->generateRandomString(10);
      $item = new users;
      $item->name = $request->input('name');
      $item->login = $request->input('login');
      $item->sold = $sold;
      $item->token = hash('md5', $request->input('login').$sold.$request->input('password'));
      $item->role = $request->input('role');
      $item->offices_id = $offices;
      $item->save();
      
      $info = new user_info;
      $info->users_id = $item->id;
			$info->users_info = "";
      $info->users_group = Group::where('prefix', $request->input('group_name'))->first()->id;
      $info->save();
      
      return true;
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
            $user_edit = users::find($id);
            if($user_edit->role == 'instructor')
            {
               $info = instructor_info::where('users_id', $id)->first();
               $info->transmission = $request->input('transmission');
               $info->number_car = $request->input('number_car');
               $info->img_car = $request->input('img_car');
               $info->img_instructor = $request->input('img_instructor');
               $info->save();
            }elseif ($user_edit->role == 'student') {
              
            }
            $offices_name = $request->input('offices');
            $offices_id = offices::where('offices_name', $offices_name)->first()->id; 
            $user_edit->offices_id = $offices_id;
            $user_edit->login = $request->input('login');
            $user_edit->role = $request->input('role');    
            $user_edit->save();
            return redirect('/users');
          case 'manager':
            $user_edit = users::find($id);
            $offices_name = $request->input('offices');
            $offices_id = offices::where('offices_name', $offices_name)->first()->id; 
            $user_edit->offices_id = $offices_id;
            $user_edit->login = $request->input('login');
            $user_edit->role = $request->input('role');    
            $user_edit->save();
            $info = users_info::where('users_id', $id)->first();
            $info->users_group = Group::where('group_name', $request->input('group_name'))->first()->id;
            $info->save();
            return redirect('/users');
          default:
          return redirect('/');
        }
      }
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      switch ($role) {
        case 'admin':   
          $offices = offices::all();
          $user_edit = users::where('id', $id)->first();
          if($user_edit->role == 'instructor')
          {
            return view('users_edit', [
                'role'=>$role,
                'user_edit'=>$user_edit,
                'offices'=>$offices,
                'img_instructor'=>instructor_info::where('users_id', $id)->first()->img_instructor,
                'img_car'=>instructor_info::where('users_id',$id)->first()->img_car,
                'transmission' => instructor_info::where('users_id',$id)->first()->transmission,
                'number_car' => instructor_info::where('users_id',$id)->first()->number_car,
            ]);
          }
          elseif ($user_edit->role == 'student') 
          {
            return view('users_edit', [
                'role'=>$role,
                'user_edit'=>$user_edit,
                'offices'=>$offices,
                'groups'=>Group::all()
            ]);
          }
          return view('users_edit', [
              'role'=>$role,
              'user_edit'=>$user_edit,
              'offices'=>$offices,
          ]);

        case 'manager':   
          $user_edit = users::where('id', $id)->first();           
          return view('users_edit', [
            'role'=>$role,
            'user_edit'=>$user_edit,
            'offices'=>offices::all(),
            'groups'=>Group::all()
          ]);
       
        default:
        return redirect('/');
      }
    	return redirect('/');
    }

    public function edit_schedule(Request $request, $id)
    {
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;

      if($request->method() == 'POST')
      {
        switch ($role) {
          case 'admin':
            $instructor = instructor_info::where('users_id', $id)->first();
            $instructor->instructors_worktime = $this->create_array_schedule($request, json_decode($instructor->instructors_worktime, true));
            $instructor->save();
            return redirect('/users');
          case 'manager':
            $instructor = instructor_info::where('users_id', $id)->first();
            $instructor->instructors_worktime = $this->create_array_schedule($request, json_decode($instructor->instructors_worktime, true));
            $instructor->save();
            return redirect('/users');
          default:
          return redirect('/');
        }
      }
      $instructor = users::find($id);
      return view('users_edit_schedule', [
          'role'=>$role,
          'instructor'=>$instructor,
          'schedule' => json_decode($instructor->get_instructors_info->instructors_worktime, true),
        ]);
    }

    public function create_array_schedule(Request $request, $table)
    {
      
      $date = $request->input('date');

      for($j=0; $j < 8; $j++)
      {
        for($i=0; $i < 7; $i++)
        {
          $works = $request->input('work'.($i));
          $time = $request->input('time'.($i));
          $table['arrDay'][0][$i]['date'] = $date[$i]; 
          $table['arrDay'][0][$i]['timeWork'][$j]['time'] = $time[$j];
          if($works[$j] == "Раб")
            $table['arrDay'][0][$i]['timeWork'][$j]['type'] = 1;
          else
            $table['arrDay'][0][$i]['timeWork'][$j]['type'] = 0;
        }
      }

      for($i=0; $i < 7; $i++){
        $table['arrDay'][0][$i]['date'] = $date[$i]; 
      }

      for($j=0; $j < 8; $j++)
      {
        for($i=0; $i < 7; $i++)
        {
          $works = $request->input('work'.($i));
          $time = $request->input('time'.($i));
          
          $table['arrDay'][1][$i]['timeWork'][$j]['time'] = $time[$j+8];
          if($works[$j+8] == "Раб")
            $table['arrDay'][1][$i]['timeWork'][$j]['type'] = 1;
          else
            $table['arrDay'][1][$i]['timeWork'][$j]['type'] = 0;
        }
      }

      for($i=0; $i < 7; $i++){
        $table['arrDay'][1][$i]['date'] = $date[$i+7]; 
      }
      return json_encode($table);
    }

    public function active_user($id)
    {
        if ($id == 0){
            return redirect('profile');
        }
        $item = users::find($id);
        $item->active = 1;
        $item->save();
        return redirect('/users-no-active');
    }

    public function remove_user($id)
    {
        if ($id == 0){
            return redirect('profile');
        }
        $item = users::find($id);
        $item->active = 0;
        $item->save();
        return redirect('/users');
    }

    public function profile()
    {
    	$token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
    	return view('welcome',[
        'role'=>$role,
        'user'=>$user,
      ]);
    }

    public function driving(Request $request)
    {
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      $orders = Orders::where('users_id', $user->id)->get();

      return view('driving',[
        'role'=>$role,
        'user'=>$user,
        'orders'=>$orders
      ]);
    }

    public function students(Request $request)
    {
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      if(isset($request->id) )
      {
        switch ($role) {
          case 'admin':
            $group = Group::find($request->id);
            return view('users_group_students',[
              'role'=>$role,
              'user'=>$user,
              'group'=>$group,
            ]);
          case 'manager':
            $group = Group::find($request->id);
            return view('users_group_students',[
              'role'=>$role,
              'user'=>$user,
              'group'=>$group,
            ]);
          default:
          return redirect('/');
        }
      }

      switch ($role) {
        case 'admin':
          return view('users_group',[
            'role'=>$role,
            'user'=>$user,
            'groups'=>Group::all(),
          ]);
        case 'manager':
          return view('users_group',[
            'role'=>$role,
            'user'=>$user,
            'groups'=>Group::where('offices_id', $user->offices_id)->get(),
          ]);
        default:
        return redirect('/');
      }
    }

    public function changePassword(Request $request, $id)
    {
      $token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;

      $newPass = $this->generateRandomString(8);

      $changeUser = users::where('id', $id)->first();
      $changeUser->token = hash('md5', $changeUser->login.$changeUser->sold.$newPass);
      $changeUser->save();

      return view('change_password', [
        'cahngeUser'=>$changeUser,
        'role'=>$role,
        'newPass'=>$newPass,
      ]);
    }

    function generateRandomString($length = 10)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
}
