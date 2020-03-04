@extends('inc.main')

@if($role == 'admin')
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Онлайн запись на вождение</h1>                 
	</div>
    <div class="col-lg-6">
        <p>Дата: {{ $data }}</p>
        <p>Время: {{ $time }}</p>
        <p>Инструктор: {{ $instructor->name }}</p>
        <form action="/online-record" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="data" value="{{ $data }}">
            <input type="hidden" name="time" value="{{ $time }}">
            <input type="hidden" name="instructor" value="{{ $instructor->id }}">
            <input type="hidden" name="week" value="{{ $week }}">
            <input type="hidden" name="student">
            <div class="form-group">
                <input type="checkbox" class="scales" name="scales1" onclick="checkbox_click(this)" checked>
                <label for="scales">Запись курсанта: </label>
                <div style="margin-bottom: 5px;">Вы выбрали: <span id="selectUser"></span></div>
                <a class="btn btn-primary" data-toggle="modal" data-target="#myModal">Выбрать</a>
            </div>
            <div class="form-group">
                <input type="checkbox" class="scales" name="scales2" onclick="checkbox_click(this)">
                <label for="scales">Запись не зарегистрированного курсанта курсанта</label>
                <input type="text" class="scales-input form-control" name="name_no_reg">
            </div>
            <div class="form-group">
                <label>Статус записи</label>
                <select name='status' class="form-control">
                    <option>Забронировать</option>
                    <option>Оплачено</option>
                    <option>Перенос</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Записать</button>    
        </form>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Поиск курсанта</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group input-group">
                            <input type="text" class=" form-control" name="quest" onchange="ajax_find_user()">
                            <span class="input-group-btn">
                                <button onclick="ajax_find_user()" class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <table id="tableUsers" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ФИО</th>
                                <th>Выбор</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td><a onclick="selectUser({{ $item->id.',\''.$item->name.'\'' }})">Выбрать</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection
@elseif($role == 'manager')
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Онлайн запись на вождение</h1>                 
    </div>

    <div class="col-lg-6">
        <p>Дата: {{ $data }}</p>
        <p>Время: {{ $time }}</p>
        <p>Инструктор: {{ $instructor->name }}</p>
        <form action="/online-record" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="data" value="{{ $data }}">
            <input type="hidden" name="time" value="{{ $time }}">
            <input type="hidden" name="instructor" value="{{ $instructor->id }}">
            <input type="hidden" name="week" value="{{ $week }}">
            <input type="hidden" name="student">

            <div class="form-group">
                <input type="checkbox" class="scales" name="scales1" onclick="checkbox_click(this)" checked>
                <label for="scales">Запись курсанта: </label>
                <div style="margin-bottom: 10px;">Вы выбрали: <span id="selectUser"></span></div>
                <a class="btn btn-primary" data-toggle="modal" data-target="#myModal">Выбрать</a>
            </div>

            <div class="form-group">
                <input type="checkbox" class="scales" name="scales2" onclick="checkbox_click(this)">
                <label for="scales">Запись не зарегистрированного курсанта курсанта</label>
                <input type="text" class="scales-input form-control" name="name_no_reg">
            </div>
            <div class="form-group">
                <label>Статус записи</label>
                <select name='status' class="form-control">
                    <option>Забронировать</option>
                    <option>Оплачено</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Записать</button>    
        </form>
        
    </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Поиск курсанта</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group input-group">
                            <input type="text" class=" form-control" name="quest" onchange="ajax_find_user()">
                            <span class="input-group-btn">
                                <button onclick="ajax_find_user()" class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <table id="tableUsers" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ФИО</th>
                                <th>Выбор</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td><a onclick="selectUser({{ $item->id.',\''.$item->name.'\'' }})">Выбрать</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>  
@endsection

@elseif($role == 'student')
@section('content')
<div class="col-lg-12">
    <h1 class="page-header">Оплата записи на вождение</h1>                 
</div>

<div class="col-lg-6">
    <p>Дата: {{ $data }}</p>
    <p>Время: {{ $time }}</p>
    <p>Инструктор: {{ $instructor->name }}</p>
    <p>К оплате: 850 руб.</p>
    <a href="{{ url('/pay?').'data='.$data.'&time='.$time.'&instructor='.$instructor->id.'&sum=850&user='.$user->id.'&week='.$week}}" type="button" class="btn btn-primary">Оплатить</a>
    
</div>  
@endsection
@endif