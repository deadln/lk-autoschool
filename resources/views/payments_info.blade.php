@extends('inc.main')

@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Профиль</h1>
    	             
        <div class="col-xs-12 col-sm-8">
            <h2>{{ $user->name }}</h2>
            <!-- <p><strong>About: </strong> Web Designer / UI. </p>
            <p><strong>Hobbies: </strong> Read, out with friends, listen to music, draw and learn new things. </p> -->
            {{-- <button type="button" class="btn btn-primary">Редактировать</button> --}}
        </div>             
	</div>	
@endsection
