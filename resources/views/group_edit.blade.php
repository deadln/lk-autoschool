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
    <div class="col-lg-12">
        <h1 class="page-header">Редактирование группы</h1>
    </div>
    <div class="col-lg-10">
        <form action="{{ url('group/edit/'.$group_edit->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label>День недели</label>
                <select name='day_of_the_week' class="form-control">
                    @foreach($DaysOfTheWeek as $Day)
                    @if($group_edit->day_of_the_week == $Day)
                    <option selected="selected">{{ $Day }}</option>
                    @else
                    <option>{{ $Day }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Дата начала</label>
                <input type="date" name="start_data" class="form-control" value="{{$group_edit->start_data}}">
            </div>
            <div class="form-group">
                <label>Преподователь</label>
                <select name='teacher' class="form-control">
                    @foreach($Teachers as $Teacher)
                    @if($group_edit->teacher == $Teacher)
                    <option selected="selected">{{ $Teacher }}</option>
                    @else
                    <option>{{ $Teacher }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            @if($role == 'admin')
            <div class="form-group">
                <label>Филиал</label>
                <select name='offices' class="form-control">
                    @foreach($offices as $office)
                        @if($group_edit->get_office->id == $office->id)
                        <option selected="selected">{{ $office->offices_name }}</option>
                        @else
                        <option>{{ $office->offices_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection