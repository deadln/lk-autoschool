<?php

namespace App\Http\Controllers;
use App\Users as users;
use Illuminate\Http\Request;
use App\Orders;
use App\InstructorsInfo;

class OnlineRecordController extends Controller
{
    public function index(Request $request){
        
    	$token = $_COOKIE['token'];
		$user = users::where('token', $token)->first();
		$role = $user->role;
		if ($role == 'admin')
    		return view('raspisanie',[
                'role'=>$role,
                'instructors' => users::where('role', 'instructor')->get(),
                'week'=>$request->week,
            ]);
    	else if ($role == 'manager')
    		return view('raspisanie',[
                'role'=>$role,
                'instructors' => users::where('role', 'instructor')->where('offices_id', $user->offices_id)->get(),
                'week'=>$request->week,
            ]);
        else if ($role == 'instructor')
        {
            $instructor_select = $request->instructor;
            $data_select = $request->data;
            if ($request->has('data') && $request->data == 0) {
                return view('raspisanie', [
                   'role'=>$role,
                   'data_select' => 0,
                   'instructor' => users::find($user->id),
                   'week'=>$request->week,
                ]);
            }
            else {
                return view('raspisanie', [
                   'role'=>$role,
                   'data_select'=>$data_select,
                   'time_select' => 0,
                   'instructor' => users::find($user->id),
                   'week'=>$request->week,
                ]);
            }
        }
        else if ($role == 'student'){
            $offices_id = $user->offices_id;
            $instructor_select = $request->instructor;
            $data_select = $request->data;
            $time_select = $request->time;
            if($request->has('instructor') && $request->instructor == 0)
                return view('raspisanie', [
                   'role'=>$role,
                   'instructor_select' => 0,
                   'instructors' => users::where('role', 'instructor')->where('offices_id', $offices_id)->get(),
                   'week'=>$request->week,
                ]);
            else if ($request->has('data') && $request->data == 0) {
                return view('raspisanie', [
                   'role'=>$role,
                   'instructor_select' => $instructor_select,
                   'data_select' => 0,
                   'instructor' => users::find($instructor_select),
                   'week'=>$request->week,
                ]);
            }
            else if ($request->has('time') && $request->time == 0) {
                return view('raspisanie', [
                   'role'=>$role,
                   'instructor_select' => $instructor_select,
                   'data_select'=>$data_select,
                   'time_select' => 0,
                   'instructor' => users::find($instructor_select),
                   'week'=>$request->week,
                ]);
            }
            else{
                return redirect('/online-record'.
                    '?instructor='.$instructor_select.
                    '&data='.$data_select.
                    '&time='.$time_select.
                    '&student='.$user->id.
                    '&week='.$request->week); 
            }
        }
    	else
    		return redirect('/');
    }

    public function record(Request $request)
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;

        if($request->method() == 'POST'){
            if ($role == 'admin')
            {
                if($request->input('scales1'))
                {
                    $order = new Orders();
                    $order->data = $request->data;
                    $order->time = $request->time;
                    $order->order_data = "";
                    $order->instructors_id = $request->instructor;
                    $order->users_id = Users::where('name', $request->student)->first()->id;
                    $order->uuid = '';
                    $order->order_status = $request->status;
                    $order->order_info = "";
                    $order->notification = 0;
                    $order->week = $request->week;
                    $order->save();

                    $this->table_entry(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->student,
                        $request->week,
                        $order->id
                    );
                }
                elseif ($request->input('scales2')) 
                {
                    $order = new Orders();
                    $order->data = $request->data;
                    $order->time = $request->time;
                    $order->order_data = "";
                    $order->instructors_id = $request->instructor;
                    $order->users_id = 0;
                    $order->uuid = '';
                    $order->order_status = $request->status;
                    $order->order_info = "";
                    $order->notification = 0;
                    $order->week = $request->week;
                    $order->save();

                    $this->table_entry_no_register(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->name_no_reg,
                        $request->week,
                        $order->id
                    );
                }
                return redirect('/raspisanie?week=1');
            }
            else if ($role == 'manager')
            {
                if($request->input('scales1'))
                {
                    $order = new Orders();
                    $order->data = $request->data;
                    $order->time = $request->time;
                    $order->order_data = "";
                    $order->instructors_id = $request->instructor;
                    $order->users_id = Users::where('name', $request->student)->first()->id;
                    $order->uuid = '';
                    $order->order_status = $request->status;
                    $order->order_info = "";
                    $order->notification = 1;
                    $order->week = $request->week;
                    $order->save();

                    $this->table_entry(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->student,
                        $request->week,
                        $order->id
                    );
                }
                elseif ($request->input('scales2'))
                {
                    $order = new Orders();
                    $order->data = $request->data;
                    $order->time = $request->time;
                    $order->order_data = "";
                    $order->instructors_id = $request->instructor;
                    $order->users_id = 0;
                    $order->uuid = '';
                    $order->order_status = $request->status;
                    $order->order_info = "";
                    $order->notification = 1;
                    $order->week = $request->week;
                    $order->save();

                    $this->table_entry_no_register(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->name_no_reg,
                        $request->week,
                        $order->id
                    );
                }
                return redirect('/raspisanie?week=1');
            }
            else
                return redirect('/'); 
        }

        if ($role == 'admin')
            return view('online_record',[
                'role'=>$role,
                'instructor' => users::find($request->instructor),
                'time' => $request->time,
                'data' => $request->data,
                'week' => $request->week,
                'student' => users::where('role', 'student')->get(),
            ]);
        else if ($role == 'manager')
            return view('online_record',[
                'role'=>$role,
                'instructor' => users::find($request->instructor),
                'time' => $request->time,
                'data' => $request->data,
                'student' => users::where('role', 'student')->get(),
                'week' => $request->week,
                ]);
        else if ($role == 'student')
            return view('online_record',[
                'role'=>$role,
                'instructor' => users::find($request->instructor),
                'time' => $request->time,
                'data' => $request->data,
                'user' => $user,
                'week' => $request->week,
            ]);
        else
            return redirect('/');
    }

    public function table_entry($data, $time, $instructor, $status, $user, $week, $order_id)
    {
        $instructor = InstructorsInfo::where('users_id', $instructor)->first();
        $schedule = json_decode($instructor->instructors_worktime, true);
        $user = Users::where('name', $user)->first()->name;
        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $data)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status'] = "Занято";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['user'] = $user;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['id_order'] = $order_id;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = $status;
                    }
                }
            }
        }

        $instructor->instructors_worktime = json_encode($schedule);
        $instructor->save();
        return;
    }

    

    public function table_entry_no_register($data, $time, $instructor, $status, $user, $week, $order_id)
    {
        $instructor = InstructorsInfo::where('users_id', $instructor)->first();
        $schedule = json_decode($instructor->instructors_worktime, true);

        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $data)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status'] = "Занято";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['user'] = $user;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['id_order'] = $order_id;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = $status;
                    }
                }
            }
        }        

        $instructor->instructors_worktime = json_encode($schedule);
        $instructor->save();
        return;
    }


    public function table_remove($data, $time, $instructor, $week)
    {
        $instructor = InstructorsInfo::where('users_id', $instructor)->first();
        $schedule = json_decode($instructor->instructors_worktime, true);
        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $data)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status'] = "Свободно";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['user'] = "";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['id_order'] = "";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = "";;
                    }
                }
            }
        } 
        
        $instructor->instructors_worktime = json_encode($schedule);
        $instructor->save();
        return;
    }

    public function edit_record(Request $request, $id)
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;
        $order = Orders::find($id);
        if($request->method() == 'POST'){
            
            if ($role == 'admin')
            {
                $order->order_status = $request->status;
                $order->notification = 1;
                $order->save();

                if($request->user_id)
                {
                    $this->table_entry_edit(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->week,
                        $order->id
                    );
                }
                else
                {
                    $this->table_entry_no_register_edit(
                        $request->data,
                        $request->time,
                        $request->instructor,
                        $request->status,
                        $request->week,
                        $order->id
                    );
                }

                return redirect('/raspisanie?week=1');
            }
            else if ($role == 'manager')
            {
                if($order->order_status != "Оплачено" && $order->order_status != "Оплачено Яндекс")
                {
                    $order->order_status = $request->status;
                    $order->notification = 1;
                    $order->save();

                    if($request->user_id)
                    {
                        $this->table_entry_edit(
                            $request->data,
                            $request->time,
                            $request->instructor,
                            $request->status,
                            $request->week,
                            $order->id
                        );
                    }
                    else
                    {
                        $this->table_entry_no_register_edit(
                            $request->data,
                            $request->time,
                            $request->instructor,
                            $request->status,
                            $request->week,
                            $order->id
                        );
                    }
                }
                return redirect('/raspisanie?week=1');
            }
            else
                return redirect('/'); 
        }

        if($order->users_id){
            $nameUser = users::find($order->users_id)->name;
        }
        else{
            $nameUser = "Не зарегистрированный курсант";
        }
        if ($role == 'admin')
            return view('online_record_edit',[
                'role'=>$role,
                'instructor' => users::find($order->instructors_id),
                'time' => $order->time,
                'data' => $order->data,
                'user_id'=> $order->users_id,
                'user_name'=> $nameUser,
                'order' => $order->id,
                'order_status' => $order->order_status,
                'week'=>$request->week
            ]);
        else if ($role == 'manager')
            return view('online_record_edit',[
                'role'=>$role,
                'instructor' => users::find($order->instructors_id),
                'time' => $order->time,
                'data' => $order->data,
                'user_id'=> $order->users_id,
                'user_name'=> $nameUser,
                'order' => $order->id,
                'order_status' => $order->order_status,
                'week'=>$request->week
            ]);
        else
            return redirect('/');
    }

    public function table_entry_edit($data, $time, $instructor, $status, $week, $order_id)
    {
        $instructor = InstructorsInfo::where('users_id', $instructor)->first();
        $schedule = json_decode($instructor->instructors_worktime, true);
        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $data)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = $status;
                    }
                }
            }
        }

        $instructor->instructors_worktime = json_encode($schedule);
        $instructor->save();
        return;
    }

    public function table_entry_no_register_edit($data, $time, $instructor, $status, $week)
    {
        $instructor = InstructorsInfo::where('users_id', $instructor)->first();
        $schedule = json_decode($instructor->instructors_worktime, true);

        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $data)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = $status;
                    }
                }
            }
        }        

        $instructor->instructors_worktime = json_encode($schedule);
        $instructor->save();
        return;
    }

    public function remove(Request $request)
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;

        if ($role == 'admin')
        {
            $this->table_remove(
                $request->data,
                $request->time,
                $request->instructor,
                $request->week
            );
            return redirect('/raspisanie?week=1');
        }
        else if ($role == 'manager')
        {
            $this->table_remove(
                $request->data,
                $request->time,
                $request->instructor,
                $request->week
            );
            return redirect('/raspisanie?week=1');
        }
        else
            return redirect('/raspisanie'); 

        return redirect('/raspisanie');
    }
}
