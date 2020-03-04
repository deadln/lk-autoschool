@extends('inc.main')

@php
    $status_arr =['Забронировать','Оплачено','Перенос'];
    $status_arr_mgr =['Забронировать','Оплачено'];
@endphp

@if($role == 'admin')
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Онлайн запись на вождение</h1>                 
	</div>

    <div class="col-lg-6">
        <p>Дата: {{ $data }}</p>
        <p>Время: {{ $time }}</p>
        <p>Инструктор: {{ $instructor->name }}</p>
        <p>Курсант: {{ $user_name }}</p>
        <form action="/online-record/edit/{{$order}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="data" value="{{ $data }}">
            <input type="hidden" name="time" value="{{ $time }}">
            <input type="hidden" name="instructor" value="{{ $instructor->id }}">
            <input type="hidden" name="week" value="{{ $week }}">
            <input type="hidden" name="order" value="{{ $order}}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div class="form-group">
                <label>Статус записи</label>
                <select name='status' class="form-control">
                    @foreach ($status_arr as $item)
                        @if ($order_status == $item)
                            <option selected>{{ $item }}</option>
                        @else
                            <option>{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form> 
    </div>
    <div class="col-lg-12" style="margin-top: 10px;">
        <a href="{{ url('/online-record/remove?').'data='.$data.'&time='.$time.'&instructor='.$instructor->id.'&week='.$week }}" class="btn btn-primary">Удалить</a>
    </div>
@endsection
@elseif($role == 'manager')
    @section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Онлайн запись на вождение</h1>                 
    </div>

    <div class="col-lg-6">
        <p>Дата: {{ $data }}</p>
        <p>Время: {{ $time }}</p>
        <p>Инструктор: {{ $instructor->name }}</p>
        <p>Курсант: {{ $user_name }}</p>
        <form action="/online-record/edit/{{$order}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="data" value="{{ $data }}">
            <input type="hidden" name="time" value="{{ $time }}">
            <input type="hidden" name="instructor" value="{{ $instructor->id }}">
            <input type="hidden" name="order" value="{{ $order}}">
            <input type="hidden" name="week" value="{{ $week }}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            
            <div class="form-group">
                <label>Статус записи</label>
                <select name='status' class="form-control">
                    @foreach ($status_arr_mgr as $item)
                        @if ($order_status == $item)
                            <option selected>{{ $item }}</option>
                        @else
                            <option>{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form> 
    </div>
    <div class="col-lg-12" style="margin-top: 10px;">
        <a href="{{ url('/online-record/remove?').'data='.$data.'&time='.$time.'&instructor='.$instructor->id.'&week='.$week }}" class="btn btn-primary">Удалить</a>
    </div>
    @endsection
@endif