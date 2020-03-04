@extends('inc.main')

@section('content')
	<div class="col-lg-10">
        <h1 class="page-header">Добавление нового офиса</h1>      
    </div>
    <div class="col-lg-10">
        <form action="{{ url('offices/add') }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <div class="form-group">
                <label>Название</label>
                <input type="name" name='name' class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>    
        </form>
    </div>
@endsection