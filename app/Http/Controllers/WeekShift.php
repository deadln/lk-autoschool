<?php

namespace App\Http\Controllers;
use App\Users as users;
use App\WeekShift as week; 
use Illuminate\Http\Request;

use App\InstructorsInfo as instructor_info;
use App\UsersInfo as user_info;

include 'Array.php';

class WeekShift extends Controller
{
    public function index(Request $request)
    {
    	$token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      if($role == 'admin')
    		return view('week_shift',[
          'role'=>$role,
          'weeks'=>week::all(),
        ]);
    	else
    		return redirect('/');
    }

    public function week(Request $request, $id)
    {
    	$token = $_COOKIE['token'];
      $user = users::where('token', $token)->first();
      $role = $user->role;
      if($role == 'admin')
    		return view('week_shift_view',[
          'role'=>$role,
          'weeks'=>week::find($id),
        ]);
    	else
    		return redirect('/');
    }

    public function Shift()
    {
      $saveOldSchedule = [];
      $instructors = instructor_info::all();
      $dateFlag = true;
      $startDate = "";
      $endDate = "";
      foreach ($instructors as $item) {
        $clearArray = getSchudeleOneWeek();
        $instructorInfo = json_decode($item->instructors_worktime, true);

        if($dateFlag){
          $startDate = $instructorInfo['arrDay'][0][0]['date'];
          $endDate = $instructorInfo['arrDay'][0][6]['date'];
          $dateFlag = false;
        }
        
        $clearArray['arrDay'] = $instructorInfo['arrDay'][0];
        $clearArray['name'] = users::find(json_decode($item->users_id))->name;
        array_push($saveOldSchedule, $clearArray);
      }

      $weekShift = new week;
      $weekShift->date_start = date("Y-m-d", strtotime($startDate));
      $weekShift->date_end = date("Y-m-d", strtotime($endDate));
      $weekShift->schedule = json_encode($saveOldSchedule);
      $weekShift->save();


      $newArr = getSchudeleNewWeek();
      foreach ($instructors as $item) {
        $instructorInfo = json_decode($item->instructors_worktime, true);
        $instructorInfo['arrDay'][0]=$instructorInfo['arrDay'][1];
        $instructorInfo['arrDay'][1] = $newArr['arrDay'];
        $item->instructors_worktime = json_encode($instructorInfo);
        $item->save();
      }
    }
}
