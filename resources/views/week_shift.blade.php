@extends('inc.main')

@section('content')
	<div class="col-lg-10">
		<h1 class="page-header">Ваши записи на вождение</h1>       
	</div>
	<div class="col-lg-10">
		<br>
	</div>
    <div class="col-lg-4">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($weeks as $element)
                        <tr>
                            <td>{{ $element->id }}</td>
                            <td>
                                <a href="{{ url('/week-shift/'.$element->id) }}">
                                    {{ date("d.m.Y",strtotime($element->date_start))." - ".date("d.m.Y",strtotime($element->date_end)) }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection