@extends('inc.main')
@php
    $role_arr =['admin','instructor','manager','student'];
@endphp
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Cоздание нового пользователя</h1>      
	</div>
	<div class="col-lg-12">
        @if($role == 'admin')
		<form action="{{ url('users/add') }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <input type="hidden" name="password" value="{{$random_password}}">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="control-label">Имя Фамилия Отчество</label>
                <input type="name" name='name' class="form-control" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span style="color: #a94442">
                        <strong>Поле не должно быть пустым</strong>
                    </span>
                @endif
            </div> 
            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <label class="control-label">Email</label>
                <input type="login" name='login' class="form-control" value="{{ old('login') }}">
                @if ($errors->has('login'))
                    <span style="color: #a94442">
                        <strong>Не правильно введен еmail</strong>
                    </span>
                @endif
            </div>  
            <div class="form-group">
                <label class="control-label">Пароль</label>
                <input type="pass" class="form-control" value="{{$random_password}}" disabled>
            </div>
            <div class="form-group">
                <label class="control-label">Права</label>
                <select name='role' class="form-control">
                    <option>admin</option>
                    <option>instructor</option>
                    <option>manager</option>
                    <option>student</option>
                </select>
            </div> 
            <div class="form-group">
                <label class="control-label">Филиал</label>
                <select name='offices' class="form-control">
                    @foreach($offices as $office)
                    <option>{{ $office->offices_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>    
        </form>
        @elseif($role == 'manager')
        <form action="{{ url('/users/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="password" value="{{$random_password}}">
            <input type="hidden" name="role" value="student">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>Имя Фамилия Отчество</label>
                <input type="name" name='name' class="form-control" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span style="color: #a94442">
                        <strong>Поле не должно быть пустым</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <label>Email</label>
                <input type="email" name="login" class="form-control" value="{{ old('login') }}">
                @if ($errors->has('login'))
                    <span style="color: #a94442">
                        <strong>Не правильно введен еmail</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="pass" class="form-control" value="{{$random_password}}" disabled>
            </div>
            <div class="form-group">
                <label>Группа</label>
                <select name='group_name' class="form-control">
                    @foreach($groups as $item)
                    <option>{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="role" value="student">
            <button type="submit" class="btn btn-primary">Создать</button>    
        </form>
        @endif
	</div>
@endsection
