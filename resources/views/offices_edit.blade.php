@extends('inc.main')

@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Редактирование офиса</h1>      
	</div>
    <div class="col-lg-10">
        <form action="{{ url('offices/edit/'.$offices_edit->id) }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <div class="form-group">
                <label>Название</label>
                <input type="name" name='name' class="form-control" value="{{ $offices_edit->offices_name }}">
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>    
        </form>
    </div>
@endsection