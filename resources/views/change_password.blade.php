@extends('inc.main')
@php
    $role_arr =['admin','instructor','manager','student'];
@endphp
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Изменение пароля пользователя</h1>
        <p><b>ФИО: </b>{{ $cahngeUser->name }}</p>
        <p><b>Новый пароль: </b> {{ $newPass }}</p>
        <a href="{{ url('/users') }}" class="btn btn-primary">Вернутся</a>    
	</div>
@endsection