@extends('inc.main')
@php
    $role_arr =['admin','instructor','manager','student'];
@endphp
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Редактирование пользователя</h1>      
	</div>
	<div class="col-lg-12">
        @if($role == 'admin')
		<form action="{{ url('users/edit/'.$user_edit->id) }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <input type="hidden" name="role" value="{{ $user_edit->role }}">
            <div class="form-group">
                <label>Имя Фамилия Отчество</label>
                <input type="name" name='name' class="form-control" value="{{ $user_edit->name }}">
            </div> 
            <div class="form-group">
                <label>Email</label>
                <input type="login" name='login' class="form-control" value="{{ $user_edit->login }}">
            </div>
            @if($user_edit->role == 'instructor')
                <div class="form-group">
                    <label>Изображение инструктора</label>
                    <input  name='img_instructor' class="form-control" value="{{ $img_instructor }}">
                </div>
                <div class="form-group">
                    <label>Изображение машины</label>
                    <input  name='img_car' class="form-control" value="{{ $img_car }}">
                </div>
                <div class="form-group">
                    <label>Каробка передач</label>
                    <input  name='transmission' class="form-control" value="{{ $transmission }}">
                </div>
                <div class="form-group">
                    <label>Номер машины</label>
                    <input  name='number_car' class="form-control" value="{{ $number_car }}">
                </div>
            @endif
            <div class="form-group">
                <label>Филиал</label>
                <select class="form-control" name="offices">
                    @foreach($offices as $office)
                        @if($user_edit->offices->id == $office->id)
                        <option selected="selected">{{ $office->offices_name }}</option>
                        @else
                        <option>{{ $office->offices_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @if($user_edit->role == 'student')
            <div class="form-group">
                <label>Группа</label>
                <select class="form-control" name="group_name">
                    @foreach($groups as $item)
                        @if($user_edit->get_users_info['users_group'] == $item->id)
                        <option selected="selected">{{$item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name}}</option>
                        @else
                        <option>{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">Сохранить</button>    
        </form>
        @elseif($role == 'manager')
        <form action="{{ url('users/edit/'.$user_edit->id) }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <div class="form-group">
                <label>Имя Фамилия Отчество</label>
                <input type="name" name='name' class="form-control" value="{{ $user_edit->name }}">
            </div> 
            <div class="form-group">
                <label>Email</label>
                <input type="login" name='login' class="form-control" value="{{ $user_edit->login }}">
            </div>
            <input type="hidden" name="role" value="student">
            <div class="form-group">
                <label>Филиал</label>
                <select class="form-control" name="offices">
                    @foreach($groups as $item)
                        @if($user_edit->get_users_info['users_group'] == $item->id)
                        <option selected="selected">{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name }}</</option>
                        @else
                        <option>{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name }}</</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>    
        </form>
        @endif
	</div>
@endsection