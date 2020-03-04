@extends('inc.mainData')
<style>
    .form-date-time{
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
@section('content')
	<div class="col-lg-12">
		<h1 class="page-header">График {{ $instructor->name }}</h1>      
	</div>
	<div class="col-lg-12">
		<form action="{{ url('users/schedule/'.$instructor->id) }}" method="POST" enctype="multipart/form-data"> 
            {{ csrf_field() }}
            <div class="form-group">
                <h4>График на первую неделю</h4>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div>ПН. {{ $schedule['arrDay'][0][0]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10" value="{{ $schedule['arrDay'][0][0]['date'] }}">
                                </th>
                                <th>
                                    <div>ВТ. {{ $schedule['arrDay'][0][1]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][1]['date'] }}">
                                </th>
                                <th>
                                    <div>СР. {{ $schedule['arrDay'][0][2]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][2]['date'] }}">
                                </th>
                                <th>
                                    <div>ЧТ. {{ $schedule['arrDay'][0][3]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][3]['date'] }}">
                                </th>
                                <th>
                                    <div>ПТ. {{ $schedule['arrDay'][0][4]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][4]['date'] }}">
                                </th>
                                <th>
                                    <div>СБ. {{ $schedule['arrDay'][0][5]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][5]['date'] }}">
                                </th>
                                <th>
                                    <div>ВС. {{ $schedule['arrDay'][0][6]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][0][6]['date'] }}">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=0;$i<8;$i++)
                            <tr>
                                @for($j=0;$j<7;$j++)
                                <td>
                                    <div>Время:</div>
                                    <input class="timepicker" type="text" name="time{{ $j }}[]" size="10" value="{{$schedule['arrDay'][0][$j]['timeWork'][$i]['time']}}"><br>
                                    <div>День:</div>
                                    @if ($schedule['arrDay'][0][$j]['timeWork'][$i]['type'] == 1)
                                        <select name="work{{ $j }}[]" class="form-control">
                                            <option selected>Раб</option>
                                            <option>Не раб</option>
                                        </select>
                                    @else
                                        <select style='color: red;' name="work{{ $j }}[]" class="form-control">
                                            <option>Раб</option>
                                            <option selected>Не раб</option>
                                        </select>
                                    @endif        
                                </td>
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <h4>График на вторую неделю</h4>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div>ПН. {{ $schedule['arrDay'][1][0]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10" value="{{ $schedule['arrDay'][1][0]['date'] }}">
                                </th>
                                <th>
                                    <div>ВТ. {{ $schedule['arrDay'][1][1]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][1]['date'] }}">
                                </th>
                                <th>
                                    <div>СР. {{ $schedule['arrDay'][1][2]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][2]['date'] }}">
                                </th>
                                <th>
                                    <div>ЧТ. {{ $schedule['arrDay'][1][3]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][3]['date'] }}">
                                </th>
                                <th>
                                    <div>ПТ. {{ $schedule['arrDay'][1][4]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][4]['date'] }}">
                                </th>
                                <th>
                                    <div>СБ. {{ $schedule['arrDay'][1][5]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][5]['date'] }}">
                                </th>
                                <th>
                                    <div>ВС. {{ $schedule['arrDay'][1][6]['date'] }}</div>
                                    <input class="datepicker" name="date[]" type="hidden" size="10"value="{{ $schedule['arrDay'][1][6]['date'] }}">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=0;$i<8;$i++)
                            <tr>
                                @for($j=0;$j<7;$j++)
                                <td>
                                    <div>Время:</div>
                                    <input class="timepicker" type="text" name="time{{ $j }}[]" size="10" value="{{$schedule['arrDay'][1][$j]['timeWork'][$i]['time']}}"><br>
                                    <div>День:</div>
                                    @if ($schedule['arrDay'][1][$j]['timeWork'][$i]['type'] == 1)
                                        <select name="work{{ $j }}[]" class="form-control">
                                            <option size=4 selected>Раб</option>
                                            <option>Не раб</option>
                                        </select>
                                    @else
                                        <select style='color: red;' name="work{{ $j }}[]" class="form-control">
                                            <option>Раб</option>
                                            <option selected>Не раб</option>
                                        </select>
                                    @endif        
                                </td>
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>    
        </form>
	</div>

@endsection