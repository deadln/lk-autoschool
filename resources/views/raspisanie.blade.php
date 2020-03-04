@extends('inc.main')
@php
    $DaysOfTheWeek = [
        'Воскресенье',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота'
    ];
@endphp

@if($role == 'admin')
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Онлайн запись на вождение</h1>                 
    </div>
    <div class="col-lg-12">
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #ccd22b;"></span> - Забранировать</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #00b31a;"></span> - Оплаченно</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #c00;"></span> - Оплаченно Онлайн</p>
    </div>
    <div class="col-lg-12">
        @if($week == '1')
        <a href="{{url('raspisanie?week=2')}}" class="btn btn-primary pull-right">Следующая неделя</a>
        @elseif($week == '2')
        <a href="{{url('raspisanie?week=1')}}" class="btn btn-primary pull-right">Предыдущая неделя</a> 
        @endif 
    </div>
    <div class="col-lg-12"><p></p></div>
    @foreach($instructors as $instructor)
    @php
        $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
    @endphp
    <div class="col-md-12" style="margin-bottom: 20px">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                @if($week == '1')
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">{{ $instructor->name }}</th>
                    </tr>
                    <tr>
                        <th>Понедельник <br>{{ $schedule['arrDay'][0][0]['date'] }}</th>
                        <th>Вторник <br>{{ $schedule['arrDay'][0][1]['date'] }}</th>
                        <th>Среда <br>{{ $schedule['arrDay'][0][2]['date'] }}</th>
                        <th>Четверг <br>{{ $schedule['arrDay'][0][3]['date'] }}</th>
                        <th>Пятница <br>{{ $schedule['arrDay'][0][4]['date'] }}</th>
                        <th>Суббота <br>{{ $schedule['arrDay'][0][5]['date'] }}</th>
                        <th>Воскресенье <br>{{ $schedule['arrDay'][0][6]['date'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=0;$i<8;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if ($schedule['arrDay'][0][$j]['timeWork'][$i]['type'] == 1)
                                @if($schedule['arrDay'][0][$j]['timeWork'][$i]['status'] =='Свободно')
                                    <td>
                                        <a href="{{ url('/online-record') }}?instructor={{ $instructor->id }}&data={{ $schedule['arrDay'][0][$j]['date']}}&time={{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}&week=1">
                                            <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>Свободно</span>
                                        </a>
                                    </td>
                                @else
                                    @php
                                        $fio = $schedule['arrDay'][0][$j]['timeWork'][$i]['user'];
                                        $fio_arr = preg_split("/[\s,]+/", $fio);
                                    @endphp

                                    @if ($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                        <td style="background: #ccd22b;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                        <td style="background: #00b31a;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                        <td style="background: rgb(38, 119, 181)">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @else
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @endif
                                    
                                @endif
                            @else
                            <td style="color: #bbb;">
                                <span>Выходной</span>
                                <br>
                                <span>&nbsp;</span>
                            </td>
                            @endif      
                        @endfor
                    </tr>
                    @endfor
                </tbody>
                @elseif($week == '2')
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">{{ $instructor->name }}</th>
                    </tr>
                    <tr>
                        <th>Понедельник <br>{{ $schedule['arrDay'][1][0]['date'] }}</th>
                        <th>Вторник <br>{{ $schedule['arrDay'][1][1]['date'] }}</th>
                        <th>Среда <br>{{ $schedule['arrDay'][1][2]['date'] }}</th>
                        <th>Четверг <br>{{ $schedule['arrDay'][1][3]['date'] }}</th>
                        <th>Пятница <br>{{ $schedule['arrDay'][1][4]['date'] }}</th>
                        <th>Суббота <br>{{ $schedule['arrDay'][1][5]['date'] }}</th>
                        <th>Воскресенье <br>{{ $schedule['arrDay'][1][6]['date'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=0;$i<8;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if ($schedule['arrDay'][1][$j]['timeWork'][$i]['type'] == 1)
                                @if($schedule['arrDay'][1][$j]['timeWork'][$i]['status'] =='Свободно')
                                    <td>
                                        <a href="{{ url('/online-record') }}?instructor={{ $instructor->id }}&data={{ $schedule['arrDay'][1][$j]['date']}}&time={{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}&week=2">
                                            <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>Свободно</span>
                                        </a>
                                    </td>
                                @else
                                    @php
                                        $fio = $schedule['arrDay'][1][$j]['timeWork'][$i]['user'];
                                        $fio_arr = preg_split("/[\s,]+/", $fio);
                                    @endphp

                                    @if ($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                        <td style="background: #ccd22b;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                        <td style="background: #00b31a;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                        <td style="background: rgb(38, 119, 181)">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @else
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @endif
                                    
                                @endif
                            @else
                            <td style="color: #bbb;">
                                <span>Выходной</span>
                                <br>
                                <span>&nbsp;</span>
                            </td>
                            @endif      
                        @endfor
                    </tr>
                    @endfor
                </tbody>
                @endif 
                
            </table>
        </div>
    </div>
    @endforeach 
@endsection

@elseif($role == 'manager')
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Онлайн запись на вождение</h1>                 
    </div>
    <div class="col-lg-12">
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #ccd22b;"></span> - Забранировать</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #00b31a;"></span> - Оплаченно</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #c00;"></span> - Оплаченно Онлайн</p>
    </div>
    <div class="col-lg-12" style="margin-bottom: 20px;">
        @if($week == '1')
        <a href="{{url('raspisanie?week=2')}}" class="btn btn-primary pull-right">Следующая неделя</a>
        @elseif($week == '2')
        <a href="{{url('raspisanie?week=1')}}" class="btn btn-primary pull-right">Предыдущая неделя</a> 
        @endif 
    </div>
    <div class="col-lg-12"><p></p></div>
    @foreach($instructors as $instructor)
    @php
        $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
    @endphp
    @empty (!$schedule)
    <div class="col-md-12" style="margin-bottom: 20px">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                @if($week == '1')
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">{{ $instructor->name }}</th>
                    </tr>
                    <tr>
                        <th>Понедельник <br>{{ $schedule['arrDay'][0][0]['date'] }}</th>
                        <th>Вторник <br>{{ $schedule['arrDay'][0][1]['date'] }}</th>
                        <th>Среда <br>{{ $schedule['arrDay'][0][2]['date'] }}</th>
                        <th>Четверг <br>{{ $schedule['arrDay'][0][3]['date'] }}</th>
                        <th>Пятница <br>{{ $schedule['arrDay'][0][4]['date'] }}</th>
                        <th>Суббота <br>{{ $schedule['arrDay'][0][5]['date'] }}</th>
                        <th>Воскресенье <br>{{ $schedule['arrDay'][0][6]['date'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=0;$i<8;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if ($schedule['arrDay'][0][$j]['timeWork'][$i]['type'] == 1)
                                @if($schedule['arrDay'][0][$j]['timeWork'][$i]['status'] =='Свободно')
                                    <td>
                                        <a href="{{ url('/online-record') }}?instructor={{ $instructor->id }}&data={{ $schedule['arrDay'][0][$j]['date']}}&time={{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}&week=1">
                                            <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>Свободно</span>
                                        </a>
                                    </td>
                                @else
                                    @php
                                        $fio = $schedule['arrDay'][0][$j]['timeWork'][$i]['user'];
                                        $fio_arr = preg_split("/[\s,]+/", $fio);
                                    @endphp

                                    @if ($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                        <td style="background: #ccd22b;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                        <td style="background: #00b31a;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                        <td style="background: rgb(38, 119, 181)">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][0][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                        <td style="background: #c00;">
                                            <a style="color:#fff;">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>

                                    @else
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][0][$j]['timeWork'][$i]['id_order'] }}?week=1">
                                                <span>{{ $schedule['arrDay'][0][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @endif
                                    
                                @endif
                            @else
                            <td style="color: #bbb;">
                                <span>Выходной</span>
                                <br>
                                <span>&nbsp;</span>
                            </td>
                            @endif      
                        @endfor
                    </tr>
                    @endfor
                </tbody>
                @elseif($week == '2')
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">{{ $instructor->name }}</th>
                    </tr>
                    <tr>
                        <th>Понедельник <br>{{ $schedule['arrDay'][1][0]['date'] }}</th>
                        <th>Вторник <br>{{ $schedule['arrDay'][1][1]['date'] }}</th>
                        <th>Среда <br>{{ $schedule['arrDay'][1][2]['date'] }}</th>
                        <th>Четверг <br>{{ $schedule['arrDay'][1][3]['date'] }}</th>
                        <th>Пятница <br>{{ $schedule['arrDay'][1][4]['date'] }}</th>
                        <th>Суббота <br>{{ $schedule['arrDay'][1][5]['date'] }}</th>
                        <th>Воскресенье <br>{{ $schedule['arrDay'][1][6]['date'] }}</th>
                    </tr>
                </thead>
                <tbody>
                @for($i=0;$i<8;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if ($schedule['arrDay'][1][$j]['timeWork'][$i]['type'] == 1)
                                @if($schedule['arrDay'][1][$j]['timeWork'][$i]['status'] =='Свободно')
                                    <td>
                                        <a href="{{ url('/online-record') }}?instructor={{ $instructor->id }}&data={{ $schedule['arrDay'][1][$j]['date']}}&time={{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}&week=2">
                                            <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>Свободно</span>
                                        </a>
                                    </td>
                                @else
                                    @php
                                        $fio = $schedule['arrDay'][1][$j]['timeWork'][$i]['user'];
                                        $fio_arr = preg_split("/[\s,]+/", $fio);
                                    @endphp

                                    @if ($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                        <td style="background: #ccd22b;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                        <td style="background: #00b31a;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                        <td style="background: rgb(38, 119, 181)">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @elseif($schedule['arrDay'][1][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                        <td style="background: #c00;">
                                            <a style="color:#fff;">
                                                <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @else
                                        <td style="background: #c00;">
                                            <a style="color:#fff;" href="{{ url('/online-record/edit/')."/".$schedule['arrDay'][1][$j]['timeWork'][$i]['id_order'] }}?week=2">
                                                <span>{{ $schedule['arrDay'][1][$j]['timeWork'][$i]['time'] }}</span>
                                                <br>
                                                <span>{{ $fio_arr[0] }}</span>
                                            </a>
                                        </td>
                                    @endif
                                    
                                @endif
                            @else
                            <td style="color: #bbb;">
                                <span>Выходной</span>
                                <br>
                                <span>&nbsp;</span>
                            </td>
                            @endif      
                        @endfor
                    </tr>
                    @endfor
                </tbody>
                @endif 
                
            </table>
        </div>
    </div>
    @endempty
    @endforeach 
@endsection

@elseif($role == 'instructor')
    @if(isset($data_select) && $data_select == 0)
        @section('content')
            <div class="col-lg-12">
               <h1 class="page-header">График работы</h1>             
            </div>
            <div class="col-lg-12" style="margin:10px 0;">
                @if($week == '1')
                <a href="?data=0&time=0&week=2" class="btn btn-primary">Следующая неделя</a>
                @elseif($week == '2')
                <a href="?data=0&time=0&week=1" class="btn btn-primary">Предыдущая неделя</a> 
                @endif         
            </div>
            <div class="col-lg-12"><p></p></div>
            @php
                $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
            @endphp
            <div class="col-md-12" style="margin-bottom: 20px">
                @if($week == '1')
                    @for ($i = 0; $i < 7; $i++)
                        <a href="?data={{ $schedule['arrDay'][0][$i]['date'] }}&week={{$week}}" class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                            @php
                                $time = $schedule['arrDay'][0][$i]['date'];
                                $dnum = date("w",strtotime($time)); 
                                $textday = $DaysOfTheWeek[$dnum]; 
                            @endphp
                            <p>{{$textday}}</p>
                            <p>Дата: {{ $time }}</p>
                        </a>
                    @endfor 
                @elseif($week == '2')
                    @for ($i = 0; $i < 7; $i++)
                        <a href="?data={{ $schedule['arrDay'][1][$i]['date'] }}&week={{$week}}" class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                            @php
                                $time = $schedule['arrDay'][1][$i]['date'];
                                $dnum = date("w",strtotime($time)); 
                                $textday = $DaysOfTheWeek[$dnum]; 
                            @endphp
                            <p>{{$textday}}</p>
                            <p>Дата: {{ $time }}</p>
                        </a>
                    @endfor 
                @endif   
            </div> 
        @endsection
    @else
        @section('content')
            <div class="col-lg-12">
                <h1 class="page-header">График работы</h1>                 
            </div>
            <div class="col-lg-12" >
                <p><span style="display: inline-block; width: 10px; height: 10px; background: #ccd22b;"></span> - Забранировать</p>
                <p><span style="display: inline-block; width: 10px; height: 10px; background: #00b31a;"></span> - Оплаченно</p>
                <p><span style="display: inline-block; width: 10px; height: 10px; background: #c00;"></span> - Оплаченно Онлайн</p>
            </div>
            <div class="col-lg-12"><p></p></div>
            @php
                $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
            @endphp
            <div class="col-md-12" style="margin-bottom: 20px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{$data_select}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0;$i<8;$i++)
                        <tr>
                            @for($j=0;$j<7;$j++)
                                @if($schedule['arrDay'][$week-1][$j]['date'] == $data_select)
                                    @if ($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['type'] == 1)
                                        @if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status'] =='Свободно')
                                            <td>
                                                <div>
                                                    <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                    <br>
                                                    <span>Свободно</span>
                                                </div>
                                            </td>
                                        @else
                                            @php
                                                $fio = $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['user'];
                                                $fio_arr = preg_split("/[\s,]+/", $fio);
                                            @endphp

                                            @if ($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                                <td style="background: #ccd22b;">
                                                    <div style="color:#fff;">
                                                        <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                        <br>
                                                        <span>{{ $fio_arr[0] }}</span>
                                                    </div>
                                                </td>
                                            @elseif($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                                <td style="background: #00b31a;">
                                                    <div style="color:#fff;">
                                                        <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                        <br>
                                                        <span>{{ $fio_arr[0] }}</span>
                                                    </div>
                                                </td>
                                            @elseif($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                                <td style="background: rgb(38, 119, 181)">
                                                    <div style="color:#fff;">
                                                        <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                        <br>
                                                        <span>{{ $fio_arr[0] }}</span>
                                                    </div>
                                                </td>
                                            @elseif($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                                <td style="background: #c00;">
                                                    <div style="color:#fff;">
                                                        <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                        <br>
                                                        <span>{{ $fio_arr[0] }}</span>
                                                    </div>
                                                </td>

                                            @else
                                                <td style="background: #c00;">
                                                    <div style="color:#fff;">
                                                        <span>{{ $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] }}</span>
                                                        <br>
                                                        <span>{{ $fio_arr[0] }}</span>
                                                    </div>
                                                </td>
                                            @endif
                                            
                                        @endif
                                    @else
                                    <td style="color: #bbb;">
                                        <span>Выходной</span>
                                        <br>
                                        <span>&nbsp;</span>
                                    </td>
                                    @endif
                                @endif    
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
            </div> 
        @endsection
    @endif
@elseif($role == 'student')
    @if(isset($instructor_select) && $instructor_select== 0)
        @section('content')
            <div class="col-lg-12">
                <h1 class="page-header">Выберите иструктора</h1>
            </div>
            @foreach($instructors as $instructor)
            @php
                $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
            @endphp
            @if ($schedule != null)
                <div class="col-lg-4 col-md-5 col-xs-10" style="background: #eee; margin: 20px; padding: 20px;">
                    <div class="col-lg-12 col-md-12">
                        <h4>{{ $instructor->name }}</h4>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <img src="{{$instructor->get_instructors_info->img_car}}" class="col-lg-7 col-md-7 col-xs-6">
                        <img src="{{$instructor->get_instructors_info->img_instructor}}" class=" col-lg-5 col-md-5 col-xs-6">
                    </div>
                    <div class="col-md-12 col-xs-12" style="padding-top: 10px">
                         <p>Коробка передач: {{ $instructor->get_instructors_info->transmission }}</p>
                        <p>Номер машины: {{ $instructor->get_instructors_info->number_car }}</p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <a href="?instructor={{ $instructor->id }}&data=0&time=0&week=1" class=" btn btn-primary" style="margin-top: 15px; display: block;">Выбрать</a>    
                    </div>
                </div>
             @endif 
            @endforeach 
        @endsection
    @elseif($instructor_select != 0 && isset($data_select) && $data_select == 0)
        @section('content')
            <div class="col-lg-12">
                <h1 class="page-header">Выберите день</h1>
            </div>
            <div class="col-lg-12">
                @if($week == '1')
                <a href="?instructor={{ $instructor_select }}&data=0&time=0&week=2" class="btn btn-primary">Следующая неделя</a>
                @elseif($week == '2')
                <a href="?instructor={{ $instructor_select }}&data=0&time=0&week=1" class="btn btn-primary">Предыдущая неделя</a> 
                @endif 
            </div>
            @php
                $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
            @endphp
            @if($week == '1')
                @for ($i = 0; $i < 7; $i++)
                    @if(strtotime($schedule['arrDay'][0][$i]['date']) > strtotime(date("d-m-Y")))
                    <div class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                        <p>Дата: {{ $schedule['arrDay'][0][$i]['date'] }}</p>
                        <a href="?instructor={{ $instructor_select }}&data={{ $schedule['arrDay'][0][$i]['date'] }}&time=0&week={{$week}}" class=" btn btn-primary" style="margin-top: 15px; display: block;">Выбрать</a> 
                    </div>
                    @endif
                @endfor 
            @elseif($week == '2')
                @for ($i = 0; $i < 7; $i++)
                    @if(strtotime($schedule['arrDay'][1][$i]['date']) > strtotime(date("d-m-Y")))
                    <div class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                        <p>Дата: {{ $schedule['arrDay'][1][$i]['date'] }}</p>
                        <a href="?instructor={{ $instructor_select }}&data={{ $schedule['arrDay'][1][$i]['date'] }}&time=0&week={{$week}}" class=" btn btn-primary" style="margin-top: 15px; display: block;">Выбрать</a> 
                    </div>
                    @endif
                @endfor 
            @endif   
        @endsection
    @else
        @section('content')
            <div class="col-lg-12">
                <h1 class="page-header">Выберите время</h1>
            </div>
            @php
                $schedule = json_decode($instructor->get_instructors_info->instructors_worktime, true);
            @endphp
            @if($week == '1')
                @for ($i = 0; $i < 7; $i++)
                    @if($schedule['arrDay'][0][$i]['date'] == $data_select)
                        @for ($j = 0; $j < 8; $j++)
                            @if ($schedule['arrDay'][0][$i]['timeWork'][$j]['type'] == 1 &&
                               $schedule['arrDay'][0][$i]['timeWork'][$j]['status'] == "Свободно")
                                <div class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                                    <p>Время: {{ $schedule['arrDay'][0][$i]['timeWork'][$j]['time'] }}</p>
                                    <a href="?instructor={{ $instructor_select }}&data={{$data_select}}&time={{ $schedule['arrDay'][0][$i]['timeWork'][$j]['time'] }}&week={{$week}}" class=" btn btn-primary" style="margin-top: 15px; display: block;">Выбрать</a> 
                                </div>
                            @endif
                        @endfor
                    @endif
                @endfor 
            @elseif($week == '2')
                @for ($i = 0; $i < 7; $i++)
                    @if($schedule['arrDay'][1][$i]['date'] == $data_select)
                        @for ($j = 0; $j < 8; $j++)
                            @if ($schedule['arrDay'][1][$i]['timeWork'][$j]['type'] == 1 &&
                               $schedule['arrDay'][1][$i]['timeWork'][$j]['status'] == "Свободно")
                                <div class="col-md-2 col-xs-10" style="background: #eee; margin: 20px; padding: 20px; text-align: center;">
                                    <p>Время: {{ $schedule['arrDay'][1][$i]['timeWork'][$j]['time'] }}</p>
                                    <a href="?instructor={{ $instructor_select }}&data={{$data_select}}&time={{ $schedule['arrDay'][1][$i]['timeWork'][$j]['time'] }}&week={{$week}}" class=" btn btn-primary" style="margin-top: 15px; display: block;">Выбрать</a> 
                                </div>
                            @endif
                        @endfor
                    @endif
                @endfor 
            @endif
        @endsection
    @endif
@endif