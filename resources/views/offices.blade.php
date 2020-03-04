@extends('inc.main')

@section('content')
	<div class="col-lg-10">
		<h1 class="page-header">Офисы</h1>
    	<a href="{{ url('offices/add') }}" class="btn btn-primary">Добавить</a>       
	</div>
	<div class="col-lg-10">
		<br>
	</div>
    <div class="col-lg-10">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Нахождение</th>
                        <th>Редактировать</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offices as $office)
                    <tr>
                        <td>{{ $office->id }}</td>
                        <td>{{ $office->offices_name}}</td>
                        <td><a href="{{ url('/offices/edit/'.$office->id) }}">Редактировать</a></td>
                        <td><a href="{{ url('/offices/remove/'.$office->id) }}">Удалить</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection