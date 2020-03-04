@extends('inc.main')

@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">Пользователи</h1>
        @if($role == 'admin')
    	<a href="{{ url('users/add') }}" class="btn btn-primary">Создать пользователя</a>
        @endif
	</div>
    @if($role == 'admin')
    <div class="col-lg-12">
        <p>Администраторы</p>
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
                            @foreach($admins as $admin)
                                @if($admin->active)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->login }}</td>
                                        <td><a href="{{ url('/users/edit/'.$admin->id) }}">Редактировать</a></td>
                                        <td><a href="{{ url('/users/change-password/'.$admin->id) }}">Сменить пароль</a></td>
                                        <td><a href="{{ url('/users/remove/'.$admin->id) }}">Удалить</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
    </div>
    <div class="col-lg-12">
        <p>Менеджеры</p>
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
                            @foreach($managers as $manager)
                                @if($manager->active)
                                    <tr>
                                        <td>{{ $manager->id }}</td>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->login }}</td>
                                        <td><a href="{{ url('/users/edit/'.$manager->id) }}">Редактировать</a></td>
                                        <td><a href="{{ url('/users/change-password/'.$manager->id) }}">Сменить пароль</a></td>
                                        <td><a href="{{ url('/users/remove/'.$manager->id) }}">Удалить</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
    </div>
    <div class="col-lg-12">
        <p>Инструкторы</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ФИО</th>
                        <th>Логин</th>
                        <th>Редактировать профиль</th>
                        <th>График работы</th>
                        <th>Сменить пароль</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        @if($instructor->active)
                            <tr>
                                <td>{{ $instructor->id }}</td>
                                <td>{{ $instructor->name }}</td>
                                <td>{{ $instructor->login }}</td>
                                <td><a href="{{ url('/users/edit/'.$instructor->id) }}">Редактировать</a></td>
                                <td><a href="{{ url('/users/schedule/'.$instructor->id) }}">График работы</a></td>
                                <td><a href="{{ url('/users/change-password/'.$instructor->id) }}">Сменить пароль</a></td>
                                <td><a href="{{ url('/users/remove/'.$instructor->id) }}">Удалить</a></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <p>Студенты</p>
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
                    @foreach($students as $student)
                        @if($student->active)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->login }}</td>
                                <td><a href="{{ url('/users/edit/'.$student->id) }}">Редактировать</a></td>
                                <td><a href="{{ url('/users/change-password/'.$student->id) }}">Сменить пароль</a></td>
                                <td><a href="{{ url('/users/remove/'.$student->id) }}">Удалить</a></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @elseif($role == 'manager')
    <div class="col-lg-12">
        <a href="{{url('/users/students')}}" class="btn btn-primary">Курсанты</a>
    </div>
    <div class="col-lg-12">
        <h3>Инструкторы</h3>
    </div>
    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ФИО</th>
                        <th>Логин</th>
                        <th>График работы</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->id }}</td>
                        <td>{{ $instructor->name }}</td>
                        <td>{{ $instructor->login }}</td>
                        <td><a href="{{ url('/users/schedule/'.$instructor->id) }}">График работы</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-lg-12">
        <p>Студенты</p>
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
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->login }}</td>
                        <td><a href="{{ url('/users/edit/'.$student->id) }}">Редактировать</a></td>
                        <td><a href="{{ url('/users/change-password/'.$student->id) }}">Сменить пароль</a></td>
                        <td><a href="{{ url('/users/remove/'.$student->id) }}">Удалить</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection