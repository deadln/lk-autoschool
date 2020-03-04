@extends('inc.main')

@section('content')
	<div class="col-lg-10">
		<h1 class="page-header">Ваши записи на вождение</h1>       
	</div>
	<div class="col-lg-10">
		<br>
	</div>
    <div class="col-lg-10">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Дата</th>
                        <th>Инструктор</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $item)
                    <tr>
                        @if($item->order_status == "Оплачено" ||
                            $item->order_status == "Оплаченно Яндекс" ||
                            $item->order_status == "Забронировать" ||
                            $item->order_status == "Перенос")
                        <td>{{ $item->id}}</td>
                        <td>{{ "Дата: ".$item->data}}<br>{{"Время: ".$item->time }}</td>
                        @php
                            $findUser = App\Users::find($item->instructors_id);
                        @endphp
                        @if($findUser)
                            <td>{{ $item->get_instructors_name->name }}</td>
                        @else
                            <td>Инструктор не найден</td>
                        @endif
                        <td>{{ $item->order_status }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection