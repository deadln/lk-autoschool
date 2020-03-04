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
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                @if(!$admin->active)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->login }}</td>
                                    <td><a href="{{ url('/users/active/'.$admin->id) }}">Активировать</a></td>
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
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($managers as $manager)
                                @if(!$manager->active)
                                    <tr>
                                        <td>{{ $manager->id }}</td>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->login }}</td>
                                        <td><a href="{{ url('/users/active/'.$manager->id) }}">Активировать</a></td>
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
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        @if(!$instructor->active)
                        <tr>
                            <td>{{ $instructor->id }}</td>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->login }}</td>
                            <td><a href="{{ url('/users/active/'.$instructor->id) }}">Активировать</a></td>
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
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @if(!$student->active)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->login }}</td>
                            <td><a href="{{ url('/users/active/'.$student->id) }}">Активировать</a></td>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        @if(!$instructor->active)
                            <tr>
                                <td>{{ $instructor->id }}</td>
                                <td>{{ $instructor->name }}</td>
                                <td>{{ $instructor->login }}</td>
                                <td><a href="{{ url('/users/active/'.$instructor->id) }}">Активировать</a></td>
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
                        <th>Активировать</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @if(!$student->active)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->login }}</td>
                            <td><a href="{{ url('/users/active/'.$student->id) }}">Активировать</a></td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection