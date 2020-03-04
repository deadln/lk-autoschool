@extends('inc.main')

@section('content')
	<div class="col-lg-12">
       	<h1 class="page-header">Выберите группу</h1>
	</div>
   
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Группа</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $item)
                    <tr>
                        <td><a href="{{url('/users/students?id='.$item->id)}}">{{ $item->day_of_the_week." ".date("d.m.y", strtotime($item->start_data))." ".$item->teacher." ".$item->get_office->offices_name }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
