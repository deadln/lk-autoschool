<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\Group;
use App\Offices;
class GroupController extends Controller
{
    public function index()
    {
        $token = $_COOKIE['token'];
        $user = Users::where('token', $token)->first();
        $role = $user->role;
        
        if($role == 'admin')
        {
            return view('group',[
                'role'=>$role,
                'groups' => Group::all()
            ]);
        }
        elseif($role == 'manager')
        {
            return view('group',[
                'role'=>$role,
                'groups' => Group::where('offices_id', $user->offices_id)->get()
            ]);
        }
    }

    public function add(Request $request)
    {
        $token = $_COOKIE['token'];
        $user = Users::where('token', $token)->first();
        $role = $user->role;

        if($request->method() == 'POST')
        {
            $item = new Group();
            $item->day_of_the_week = $request->input('day_of_the_week');
            $item->teacher = $request->input('teacher');
            $item->start_data = $request->input('start_data');
            switch ($role) {
                case 'admin':
                    $item->offices_id = Offices::where('offices_name', $request->input('offices'))->first()->id;
                    $item->prefix =$item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name;
                case 'manager':
                    $item->offices_id = $user->offices_id;
                    $item->prefix =$item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name;
            }
            $item->save();
            return redirect('/group');
        }

        if($role == 'admin' || $role == 'manager')
            return view('group_add', [
                'role'=>$role,
                'offices' => Offices::all()
            ]);
        else
            return redirect('/');

    }

    public function edit(Request $request, $id)
    {
        $token = $_COOKIE['token'];
        $user = users::where('token', $token)->first();
        $role = $user->role;

        if($request->method() == 'POST')
        {
            $item = Group::find($id);
            $item->day_of_the_week = $request->input('day_of_the_week');
            $item->teacher = $request->input('teacher');
            $item->start_data = $request->input('start_data');
            if($role == 'admin')
            {
                $item->offices_id = Offices::where('offices_name', $request->input('offices'))->first()->id;
                $item->prefix = $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name;
            }
            elseif($role == 'manager')
            {
                $item->offices_id = $user->offices_id;
                $item->prefix = $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name;
            }
            $item->save();
            return redirect('/group');
        }

        $offices_edit = Group::where('id', $id)->first();
        return view('group_edit', [
            'role'=>$role,
            'group_edit'=>$offices_edit,
            'offices' => Offices::all()
        ]);
    }

    public function remove($id)
    {
        if ($id == 0){
            return redirect('profile');
        }
        $item = Group::find($id);
        $item->delete();
        return redirect('/group');
    }
}
