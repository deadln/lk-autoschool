@extends('inc.main')
@php
    $DaysOfTheWeek = [
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
        'Воскресенье'
    ];

    $Teachers = [
        'Гладкоскок С.С.',
        'Мамаев В.Ю.',
        'Ермаков М.В.',
        'Амарантов Д.А.',
        'Капранов А.А.',
        'Дрожжин Н.А.'
    ];

@endphp
@section('content')
    <div class="col-lg-7">
        <h1 class="page-header">Добавление новой группы</h1>
    </div>
    <div class="col-lg-7">
        <form action="{{ url('group/add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label>День недели</label>
                <select name='day_of_the_week' class="form-control">
                    @foreach($DaysOfTheWeek as $Day)
                    <option>{{ $Day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Дата начала</label>
                <input type="date" name="start_data" class="form-control">
            </div>
            <div class="form-group">
                <label>Преподователь</label>
                <select name='teacher' class="form-control">
                    @foreach($Teachers as $Teacher)
                    <option>{{ $Teacher }}</option>
                    @endforeach
                </select>
            </div>
            @if($role == 'admin')
            <div class="form-group">
                <label>Филиал</label>
                <select name='offices' class="form-control">
                    @foreach($offices as $office)
                    <option>{{ $office->offices_name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection