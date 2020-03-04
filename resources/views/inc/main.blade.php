<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Личный кабинет</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('/assets/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('/assets/dist/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('/assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Личный кабинет</a>
            </div>
            <!-- /.navbar-header -->

            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    @if($role == 'admin')
                    <ul class="nav" id="side-menu">
                        <li class="active">
                            <a href="{{ url('/profile') }}"><i class="fa fa-list-alt fa-fw"></i>  Профиль</a>
                        </li>
                        <li>
                            <a href="{{ url('/static') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Статистика</a>
                        </li>
                        <li>
                            <a href="{{ url('/week-shift') }}"><i class="fa fa-calendar-check-o fa-fw"></i> Старое расписание</a>
                        </li>
                        <li>
                            <a href="{{ url('/raspisanie?week=1') }}"><i class="fa fa-calendar fa-fw"></i> Онлайн запись</a>
						</li>
						<li>
							<a href="{{ url('/raspisanie?week=1') }}"><i class="fa fa-money fa-fw"></i> Платежи</a>
						</li>
                        <li>
                            <a href="{{ url('/offices') }}"><i class="fa fa-building-o fa-fw"></i> Офисы</a>
                        </li>
                        <li>
                            <a href="{{ url('/group') }}"><i class="fa fa-users fa-fw"></i> Группы</a>
                        </li>
                        <li>
                            <a href="{{ url('/users') }}"><i class="fa fa-user fa-fw"></i> Пользователи</a>
                        </li>
                        <li>
                            <a href="{{ url('/users-no-active') }}"><i class="fa fa-user-times" aria-hidden="true"></i> Не активные пользователи</a>
                        </li>
                        <li>
                            <a href="{{ url('/exit') }}"><i class="fa fa-sign-out  fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    @elseif($role == 'manager')
                    <ul class="nav" id="side-menu">
                        <li class="active">
                            <a href="{{ url('/profile') }}"><i class="fa fa-list-alt fa-fw"></i>  Профиль</a>
                        </li>
                        <li>
                            <a href="{{ url('/raspisanie?week=1') }}"><i class="fa fa-calendar fa-fw"></i> Вождение</a>
                        </li>
                        <li>
                            <a href="{{ url('/group') }}"><i class="fa fa-users fa-fw"></i> Группы</a>
                        </li>
                        <li>
                            <a href="{{ url('/users') }}"><i class="fa fa-user fa-fw"></i> Пользователи</a>
                        </li>
                        <li>
                            <a href="{{ url('/exit') }}"><i class="fa fa-sign-out  fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    @elseif($role == 'instructor')
                    <ul class="nav" id="side-menu">
                        <li class="active">
                            <a href="{{ url('/profile') }}"><i class="fa fa-list-alt fa-fw"></i>  Профиль</a>
                        </li>
                        <li>
                            <a href="{{ url('/raspisanie?data=0&week=1') }}"><i class="fa fa-calendar fa-fw"></i> Записи</a>
                        </li>
                        <li>
                            <a href="{{ url('/exit') }}"><i class="fa fa-sign-out  fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    @elseif($role == 'student')
                    <ul class="nav" id="side-menu">
                        <li class="active">
                            <a href="{{ url('/profile') }}"><i class="fa fa-list-alt fa-fw"></i>  Профиль</a>
                        </li>
                        <li>
                            <a href="{{ url('/raspisanie') }}?instructor=0&data=0&time=0&week=1"><i class="fa fa-calendar fa-fw"></i> Онлайн запись</a>
                        </li>
                        <li>
                            <a href="{{ url('/driving') }}"><i class="fa fa-calendar fa-fw"></i> Вождение</a>
                        </li>
                        <li>
                            <a href="{{ url('/exit') }}"><i class="fa fa-sign-out  fa-fw"></i> Выход</a>
                        </li>
                    </ul>
                    @endif
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    
    <!-- /.modal-dialog -->

    <!-- jQuery -->
    <script src="{{ url('/assets/vendor/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ url('/assets/vendor/metisMenu/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ url('/assets/dist/js/sb-admin-2.js') }}"></script>
    <script src="{{ url('/assets/data/application.js') }}"></script>
    <script src="{{ url('/assets/dist/js/common.js') }}"></script>

</body>

</html>
