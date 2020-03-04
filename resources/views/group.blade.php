@extends('inc.main')

@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Группы</h1>
        <a href="{{ url('group/add') }}" class="btn btn-primary">Добавить</a>
    </div>
    <div class="col-lg-10">
        <br>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            @if($role == 'admin')
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название Группы</th>
                    <th>Филиал</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name}}</td>
                        <th>{{ $item->get_office->offices_name}}</th>
                        <td><a href="{{ url('/group/edit/'.$item->id) }}">Редактировать</a></td>
                        <td><a href="{{ url('/group/remove/'.$item->id) }}">Удалить</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @elseif($role == 'manager')
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Группа</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name}}</td>
                        <td><a href="{{ url('/group/edit/'.$item->id) }}">Редактировать</a></td>
                        <td><a href="{{ url('/group/remove/'.$item->id) }}">Удалить</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection