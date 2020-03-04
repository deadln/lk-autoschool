@extends('inc.main')
@php
    $role_arr =['admin','instructor','manager','student'];
@endphp
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Создан новый пользователь</h1>
        <p><b>Логин: </b>{{ $login }}</p>
        <p><b>ФИО: </b>{{ $name }}</p>
        <p><b>Права: </b>{{ $role }}</p>
        <p><b>Офис: </b> {{ $office }}</p>
        <p><b>Пароль: </b> {{ $pass }}</p>
        <a href="{{ url('/users') }}" class="btn btn-primary">Дальше</a>    
	</div>
@endsection