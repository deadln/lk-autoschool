@extends('inc.main')

@section('content')
	<div class="col-lg-12">
        <h1 class="page-header">Курсанты из группы {{$group->group_name}}</h1>
        <a href="{{ url('users/add') }}" class="btn btn-primary">Создать пользователя</a>
        <p>&nbsp;</p>
	</div>    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ФИО</th>
                        <th>Логин</th>
                        <th>Редактировать</th>
                        <th>Сменить пароль</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($group->get_users_info); $i++)
                    <tr>
                        <td>{{ $group->get_users_info[$i]->get_users["id"] }}</td>
                        <td>{{ $group->get_users_info[$i]->get_users["name"] }}</td>
                        <td>{{ $group->get_users_info[$i]->get_users["login"] }}</td>
                        <td><a href="{{ url('/users/edit/'.$group->get_users_info[$i]->get_users['id']) }}">Редактировать</a></td>
                        <td><a href="{{ url('/users/change-password/'.$group->get_users_info[$i]->get_users['id']) }}">Сменить пароль</a></td>
                        <td><a href="{{ url('/users/remove/'.$group->get_users_info[$i]->get_users['id']) }}">Удалить</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection