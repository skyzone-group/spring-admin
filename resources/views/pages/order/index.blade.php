@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Заказы</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">Заказы</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Заказы</h3>
                            <span class="badge badge-light">@lang('global.amount') : {{ $orders->total() ?? 0 }}</span>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button name="filter" type="button" value="1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#filter-modal"><i class="fas fa-filter"></i> @lang('global.filter')</button>
                                    <form action="" method="get">
                                        <div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filters" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">@lang('global.filter')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <!-- full_name -->
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Пользователи</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm">
                                                                    <option value="like"> like </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="hidden" name="name_operator" value="like">
                                                                <input class="form-control form-control-sm" type="text" name="name" value="{{ old('name',request()->name??'') }}">
                                                            </div>
                                                        </div>

                                                        <!-- status -->
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Статус</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm">
                                                                    <option value=""> = </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <select class="form-control form-control-sm" name="status_admin">
                                                                    <option value=""></option>
                                                                    <option value="0" {{ (request()->status_admin == '0') ? 'selected':'' }}>Новый</option>
                                                                    <option value="5" {{ request()->status_admin == 5 ? 'selected':'' }}>Отправить в Telegram</option>
                                                                    <option value="4" {{ request()->status_admin == 4 ? 'selected':'' }}>Отменен</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- payment_status -->
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Статус оплаты</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm">
                                                                    <option value=""> = </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <select class="form-control form-control-sm" name="payment">
                                                                    <option value=""></option>
                                                                    <option value="0" {{ (request()->payment == '0') ? 'selected':'' }}>Не Оплачен</option>
                                                                    <option value="1" {{ request()->payment == 1 ? 'selected':'' }}>Оплачен</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- summa  -->
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Сумма</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm" name="summa_operator"
                                                                        onchange="
                                                                                if(this.value == 'between'){
                                                                                document.getElementById('summa_pair').style.display = 'block';
                                                                                } else {
                                                                                document.getElementById('summa_pair').style.display = 'none';
                                                                                }
                                                                                ">
                                                                    <option value="" {{ request()->summa_operator == '=' ? 'selected':'' }}> = </option>
                                                                    <option value=">" {{ request()->summa_operator == '>' ? 'selected':'' }}> > </option>
                                                                    <option value="<" {{ request()->summa_operator == '<' ? 'selected':'' }}> < </option>
                                                                    <option value="between" {{ request()->summa_operator == 'between' ? 'selected':'' }}> Between </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <input class="form-control form-control-sm" type="text" name="summa" value="{{ old('summa',request()->summa??'') }}">
                                                            </div>
                                                            <div class="col-3" id="summa_pair" style="display: {{ request()->summa_operator == 'between' ? 'block':'none'}}">
                                                                <input class="form-control form-control-sm" type="text" name="summa_pair" value="{{ old('summa_pair',request()->summa_pair ??'') }}">
                                                            </div>
                                                        </div>

                                                        <!-- payment_method -->
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Тип оплаты</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm">
                                                                    <option value=""> = </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <select class="form-control form-control-sm" name="payment_method">
                                                                    <option value=""></option>
                                                                    <option value="naqd" {{ (request()->payment_method == 'naqd') ? 'selected':'' }}>💵 Наличные</option>
                                                                    <option value="plastik" {{ request()->payment_method == 'plastik' ? 'selected':'' }}>💳 Пластик</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row align-items-center">
                                                            <div class="col-3">
                                                                <h6>Дата создания</h6>
                                                            </div>
                                                            <div class="col-2">
                                                                <select class="form-control form-control-sm" name="created_at_operator"
                                                                        onchange="
                                                                                if(this.value == 'between'){
                                                                                document.getElementById('created_at_pair').style.display = 'block';
                                                                                } else {
                                                                                document.getElementById('created_at_pair').style.display = 'none';
                                                                                }
                                                                                ">
                                                                    <option value="like" {{ request()->created_at_operator == '=' ? 'selected':'' }}> = </option>
                                                                    <option value=">" {{ request()->created_at_operator == '>' ? 'selected':'' }}> > </option>
                                                                    <option value="<" {{ request()->created_at_operator == '<' ? 'selected':'' }}> < </option>
                                                                    <option value="between" {{ request()->created_at_operator == 'between' ? 'selected':'' }}> От .. до .. </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3">
                                                                <input class="form-control form-control-sm" type="date" name="created_at" value="{{ old('created_at',request()->created_at??'') }}">
                                                            </div>
                                                            <div class="col-3" id="created_at_pair" style="display: {{ request()->created_at_operator == 'between' ? 'block':'none'}}">
                                                                <input class="form-control form-control-sm" type="date" name="created_at_pair" value="{{ old('created_at_pair',request()->created_at_pair??'') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="filter" class="btn btn-primary">@lang('global.filtering')</button>
                                                        <button type="button" class="btn btn-outline-warning float-left pull-left" id="reset_form">@lang('global.clear')</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.closed')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="{{ route('orderIndex') }}" class="btn btn-secondary btn-sm"><i class="fa fa-redo-alt"></i> @lang('global.clear')</a>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-responsive-lg">
                                <thead>
                                <tr class="text-center">
                                    <th>№</th>
                                    <th>Дата создания</th>
                                    <th>Пользователи</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Статус оплаты</th>
                                    <th>Тип оплаты</th>
                                    <th style="width: 40px">@lang('global.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td style="text-align: center">{{ $order->id }}</td>
                                        <td>{{ date('H:i:s d-m-Y', strtotime($order->created_at)) }}</td>
                                        <td> {{ $order->botuser->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @php
                                                    if($order->status_admin == 0)
                                                    {
                                                        $color = 'warning';
                                                        $text = "Новый";
                                                    }
                                                    elseif($order->status_admin == 1)
                                                    {
                                                        $color = 'primary';
                                                        $text = "Новый";
                                                    }
                                                    elseif($order->status_admin == 2)
                                                    {
                                                        $color = 'primary';
                                                        $text = "Новый";
                                                    }
                                                    elseif($order->status_admin == 3)
                                                    {
                                                        $color = 'success';
                                                        $text = "Новый";
                                                    }
                                                    elseif($order->status_admin == 4)
                                                    {
                                                        $color = 'danger';
                                                        $text = "Отменен";
                                                    }
                                                    elseif($order->status_admin == 5)
                                                    {
                                                        $color = 'primary';
                                                        $text = "Отправить в Telegram";
                                                    }
                                                @endphp
                                                <button id="status_{{$order->id}}" class=" btn btn-{{$color}} btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$text}}
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button onclick="changeStatus('{{$order->id}}', '0','st')" class="dropdown-item" href="">Новый</button>
                                                    <button onclick="changeStatus('{{$order->id}}', '5','st')" class="dropdown-item" href="">Отправить в Telegram</button>
                                                    <button onclick="changeStatus('{{$order->id}}', '4','st')" class="dropdown-item" href="">Отменен</button>

                                                </div>
                                            </div>

                                        </td>

                                        <td>{{ number_format($order->summa, 0,' ',' ')." сум" }}</td>

                                        <td class="text-center">
                                            {{--                                            {{ $order->payment }}--}}
                                            <button id="payment_{{$order->id}}" class="btn btn-{{$order->payment == 0 ? 'danger' : 'success'}} btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{$order->payment == 0 ? "Не Оплачен" : "Оплачен"}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <button onclick="changePayment('{{$order->id}}', '0','pay')" class="dropdown-item" href="#">Не Оплачен</button>
                                                <button onclick="changePayment('{{$order->id}}', '1','pay')" class="dropdown-item" href="#">Оплачен</button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $order->payment_method == 'naqd' ? '💵 Наличные' : '💳 Пластик' }}

                                        </td>
                                        <td class="text-center" style="vertical-align: middle">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modal-lg_{{$order->id}}">
                                                    @lang('global.details')
                                                </button>
                                                {{--                                                <a href="{{ "categoryIndex" }}"  ></a>--}}
                                            </div>
                                            <!-- /.modal -->

                                            <div class="modal fade" id="modal-lg_{{$order->id}}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Заказы №{{$order->id}}</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <table class="table table-striped">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="width: 40%">Имя:</td>
                                                                    <td>
                                                                        <b>{{$order->botuser->name}}</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Телефон:</td>
                                                                    <td>
                                                                        {{$order->botuser->phone}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Тип заказа:</td>
                                                                    <td>
                                                                        {{$order->order_type == "take_away" ? "Самовывоз" : "Доставка"}}
                                                                    </td>
                                                                </tr>
                                                                @if($order->order_type == 'take_away')
                                                                    <tr>
                                                                        <td>Время доставки:</td>
                                                                        <td>
                                                                            {{ $order->order_time}}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if($order->order_type == 'delivery')
                                                                    <tr>
                                                                        <td>Время:</td>
                                                                        <td>
                                                                            {{ $order->delivery_time}}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td>Тип оплаты:</td>
                                                                    <td>
                                                                        {{ $order->payment_method == 'naqd' ? '💵 Наличные' : '💳 Пластик' }}
                                                                    </td>
                                                                </tr>
                                                                @if($order->order_type == 'delivery')
                                                                    <tr>
                                                                        <td>Адрес:</td>
                                                                        <td>
                                                                            {{$order->address == "0" ? "Геолокация в телеграмме" : $order->address}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address in admin panel:</td>
                                                                        <td>
                                                                            {{$order->botuser->address ?? "-"}}
                                                                            <div class="btn-group">
                                                                                <a href="{{ route('botuserEditaddress',$order->botuser->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td>Комментарий к заказу:</td>
                                                                    <td>
                                                                        {{$order->comment == "no" ? "Нет заметки" : $order->comment}}
                                                                    </td>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Продукты</th>
                                                                    <th>Цена</th>
                                                                    <th>Количество</th>
                                                                    <th>Итого</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php $totalSumma = 0; $count = 0;
                                                                    if($order->order_type == 'delivery') $totalSumma = $order->d_price;
                                                                @endphp
                                                                @foreach($order->orderitem as $orderitem)
                                                                    <tr>
                                                                        <td>{{isset($orderitem->product->name_ru) ? $orderitem->product->name_ru : 'Deleted'}}</td>
                                                                        <td>{{number_format($orderitem->price, 0,' ',' ')." сум"}}</td>
                                                                        <td>
                                                                            {{$orderitem->quantity}}
                                                                        </td>
                                                                        <td>
                                                                            {{number_format($orderitem->quantity * $orderitem->price, 0,' ',' ')." сум"}}
                                                                        </td>
                                                                        @php $count += 1; $totalSumma += $orderitem->quantity * $orderitem->price; @endphp
                                                                    </tr>
                                                                @endforeach

                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b>Сумма заказа:</b>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <b>{{number_format($order->summa - $order->d_price, 0,' ',' ')." сум"}}</b>
                                                                    </td>
                                                                </tr>
                                                                @if($order->order_type == 'delivery')
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <b>Цена доставки:</b>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <b>{{number_format($order->d_price, 0,' ',' ')." сум"}}</b>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b>Общий продукт:  {{$count}}</b>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <b>Итого сумма:  {{number_format($totalSumma, 0,' ',' ')." сум"}}</b>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                            {{--                                                            <button type="button" class="btn btn-primary">Save changes</button>--}}
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script !src="">
        function changeStatus($x, $y, $t) {

            let button = $("#status_"+$x);

            let order_id = $x;
            let status = $y;
            let types = $t;

            $.ajax({
                url:'/order/status',
                type: "POST",
                data:{
                    order_id: order_id,
                    status: status,
                    types: types,
                    _token: "{!! @csrf_token() !!}"
                },
                beforeSend:function () {
                    SpinnerGo(button);
                },
                success:function (result) {
                    if(result.status)
                    {
                        let classes = ['warning','primary','primary','success','danger','primary'];
                        let text = ['Новый','Новый','Новый','Новый','Отменен','Отправить в Telegram'];
                        button.attr('class',"btn-sm dropdown-toggle btn btn-"+classes[$y]);
                        console.log(classes[$y]);
                        button.text(text[$y]);
                    }
                    else
                    {

                    }
                    SpinnerStop(button);
                },
                error:function(err){
                    console.log(err);
                    SpinnerStop(button);
                }
            })



        }
        function changePayment($x, $y, $t) {


            let button = $("#payment_"+$x);
            let order_id = $x;
            let status = $y;
            let types = $t;

            $.ajax({
                url:'/order/status',
                type: "POST",
                data:{
                    order_id: order_id,
                    status: status,
                    types: types,
                    _token: "{!! @csrf_token() !!}"
                },
                beforeSend:function () {
                    SpinnerGo(button);
                },
                success:function (result) {
                    if(result.status)
                    {
                        let classes = ['danger','success'];
                        let text = ['Не Оплачен','Оплачен'];
                        button.attr('class',"btn-sm dropdown-toggle btn btn-"+classes[$y]);
                        console.log(classes[$y]);

                        button.text(text[$y]);
                    }
                    else
                    {

                    }
                    SpinnerStop(button);
                },
                error:function(err){
                    console.log(err);
                    SpinnerStop(button);
                }
            })



        }
    </script>
@endsection()
