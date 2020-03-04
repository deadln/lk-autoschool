@extends('inc.main')

@section('content')
	<div class="col-lg-10">
		<h1 class="page-header">Расписание с {{date("d.m.Y",strtotime($weeks->date_start))}} по {{date("d.m.Y",strtotime($weeks->date_end))}}</h1>       
	</div>
    <div class="col-lg-12">
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #ccd22b;"></span> - Забранировать</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #00b31a;"></span> - Оплаченно</p>
        <p><span style="display: inline-block; width: 10px; height: 10px; background: #c00;"></span> - Оплаченно Онлайн</p>
    </div>
	<div class="col-lg-10">
		<br>
	</div>
    @php
        $arr = json_decode($weeks->schedule, true);
    @endphp
    @foreach($arr as $schedule)
    <div class="col-md-12" style="margin-bottom: 20px">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">{{ $schedule['name'] }}</th>
                    </tr>
                    <tr>
                        <th>Понедельник <br>{{ $schedule['arrDay'][0]['date'] }}</th>
                        <th>Вторник <br>{{ $schedule['arrDay'][1]['date'] }}</th>
                        <th>Среда <br>{{ $schedule['arrDay'][2]['date'] }}</th>
                        <th>Четверг <br>{{ $schedule['arrDay'][3]['date'] }}</th>
                        <th>Пятница <br>{{ $schedule['arrDay'][4]['date'] }}</th>
                        <th>Суббота <br>{{ $schedule['arrDay'][5]['date'] }}</th>
                        <th>Воскресенье <br>{{ $schedule['arrDay'][6]['date'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=0;$i<8;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if ($schedule['arrDay'][$j]['timeWork'][$i]['type'] == 1)
                                @if($schedule['arrDay'][$j]['timeWork'][$i]['status'] =='Свободно')
                                    <td>
                                        <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                        <br>
                                        <span>Свободно</span>
                                    </td>
                                @else
                                    @php
                                        $fio = $schedule['arrDay'][$j]['timeWork'][$i]['user'];
                                        $fio_arr = preg_split("/[\s,]+/", $fio);
                                    @endphp

                                    @if ($schedule['arrDay'][$j]['timeWork'][$i]['status_order'] == "Забронировать")
                                        <td style="background: #ccd22b; color:#fff;">
                                            <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>{{ $fio_arr[0] }}</span>
                                        </td>
                                    @elseif($schedule['arrDay'][$j]['timeWork'][$i]['status_order'] == "Оплачено")
                                        <td style="background: #00b31a; color:#fff;">
                                            <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>{{ $fio_arr[0] }}</span>
                                        </td>
                                    @elseif($schedule['arrDay'][$j]['timeWork'][$i]['status_order'] == "Перенос")
                                    <td style="background: rgb(38, 119, 181); color: #fff;">
                                        <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                        <br>
                                        <span>{{ $fio_arr[0] }}</span>
                                    </td>
                                    @elseif($schedule['arrDay'][$j]['timeWork'][$i]['status_order'] == "Оплачено Яндекс")
                                        <td style="background: #c00;color:#fff;">
                                            <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>{{ $fio_arr[0] }}</span>
                                        </td>
                                    @else
                                        <td style="background: #c00;color:#fff;">
                                            <span>{{ $schedule['arrDay'][$j]['timeWork'][$i]['time'] }}</span>
                                            <br>
                                            <span>{{ $fio_arr[0] }}</span>
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
            </table>
        </div>
    </div>
    @endforeach 
    
@endsection