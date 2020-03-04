@extends('inc.static_main')

@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Статистика</h1>                 
	</div>
	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Статистика зарегистрированных пользователей
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-area-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>                    
        <!-- /.panel -->
    </div>

	<!-- Morris Charts JavaScript -->
    <script src="{{ url('/assets/vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ url('/assets/vendor/morrisjs/morris.min.js') }}"></script>
    <script src="{{ url('/assets/data/morris-data.js') }}"></script>
	
@endsection