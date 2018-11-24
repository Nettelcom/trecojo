<?php
$rqController = new \App\Http\Controllers\Admin\RequestController;
$notify =  $rqController->rememberRequest();
$countNotify = count($notify["company"] )+ count($notify["client"]);
$json_data = json_encode($notify);

//dump($json_data);
?>
@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Notificaciones<small>Mostrando Notificaciones del día</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Notificaciones</li>
        </ol>
    </section>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Cliente Persona</div>
                </div>

            </div>

        </div>
    </div>

    <div class="box">
        <div class="box-header" style="display: flex">
            {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                {{--<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">--}}

                {{--<div class="input-group-btn">--}}
                    {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
                {{--</div>--}}

            {{--</div>--}}
            <div style="margin-left: 10px">
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClient">Agregar Cliente</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Cliente</th>
                    <th>Conductor</th>
                    <th>Vehículo</th>
                    <th>Fecha/Hora Recojo</th>

                    {{--<th>Fecha Pedido</th>--}}
                    {{--<th>Fecha Recojo</th>--}}
                    {{--<th>Fecha Fin</th>--}}

                    <th>Precio</th>
                    <th>Pago Conductor</th>
                    <th>Margen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>¿Aceptó?</th>
                    <th>Courier</th>
                    {{--<th>Tipo de Pago</th>--}}
                    {{--<th>Pagado?</th>--}}
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody id="body_client">
{{--                {{ dd($request[0]["id"])}}--}}
                @for($i = 0; $i < count($request); $i++)

                    <form action="update_data_request" method="post">
                        <td style="display: none"><input type="text" name="inicio" value="{{$request[$i]["start_address"]}}"></td>
                        <td style="display: none"><input type="text" name="fin" value="{{$request[$i]["end_address"]}}"></td>
                        <td style="display: none"><input type="text" name="send_mail" value="1"></td>
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequest" value="{{$request[$i]["id"]}}">
                        <tr>
                            <td>{{$request[$i]["id"]}}</td>
                            <td>
                                @foreach($clients as $client)
                                    @if($request[$i]["client_id"]== $client->id)
                                        {{$client->first_name}}  {{$client->last_name}}
                                    @endif

                                @endforeach
                            </td>
                            <td>
                                <select class="form-control" name="provider_id" id="">
                                    <option value="">Seleccione un Conductor</option>
                                    @foreach($providers as $provider)
                                        @foreach($car as $cr)
                                            @if($provider->id == $cr->idprovider)
                                                @if($request[$i]["id_type_car"] == $cr->type)
                                                    <option value="{{$provider->id}}"
                                                            @if($provider->id == $request[$i]["provider_id"])
                                                            selected="selected"
                                                            @endif
                                                    >{{$provider->first_name}}  {{$provider->last_name}}</option>

                                                @endif()
                                            @endif
                                        @endforeach
                                    @endforeach

                                </select>


                            </td>
                            <td>
                                @foreach($type_car as $t_car)
                                    @if($request[$i]["id_type_car"] == $t_car->id)
                                        {{$t_car->type_c}}
                                    @endif

                                @endforeach
                            </td>
                            <td>{{$request[$i]["date_arrive"]}}</td>


                            <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$request[$i]["cost_amount"]}}"></td>
                            <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$request[$i]["cost_provider"]}}"></td>
                            <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$request[$i]["margin"]}}"></td>
                            <td style="display: none;"><input type="hidden" size="10"  name="pTotal" {{ $request[$i]["pTotal"] }}  ></td>
                            <td>{{$request[$i]["start_address"]}}</td>
                            <td>{{$request[$i]["end_address"]}}</td>
                            <td style="text-align: center">
                                @if($request[$i]["status_request"] == 0)
                                    <a href="{{route("change_state_request",[$request[$i]["id"]])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                                @else
                                    <a href="{{route("change_state_request",[$request[$i]["id"]])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif
                            </td>
                            <td>
                                @if($request[$i]["is_courier"] == 0)

                                    <a class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                                @else
                                    <a class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif


                            </td>
                            {{--<td style="text-align: center">--}}
                                {{--@if($request[$i]["is_paint"]== 0)--}}
                                    {{--<a href="{{route("change_is_payment_request",[$request[$i]["id"]])}}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>--}}
                                {{--@else--}}
                                    {{--<a href="{{route("change_is_payment_request",[$request[$i]["id"]])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>--}}
                                {{--@endif--}}

                            {{--</td>--}}
                            <td>
                                {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                                <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                                <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
                                {{--<a data-toggle="modal" data-target="#detailsRequest" class="btn btn-info btn_details_request" id="{{$request[$i]["id"]}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>--}}
                                <a href="{{route("delete_request", [ $request[$i]["id"] ])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </form>
                @endfor
                </tbody>

                </tfoot>
            </table>
        </div>




    {{--COMPANy--}}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Cliente Empresa</div>
                </div>

            </div>

        </div>
    </div>

    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#id</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Conductor</th>
                <th>Vehículo</th>
                {{--<th>Fecha Pedido</th>--}}
                <th>Fecha/Hora Recojo</th>
                {{--<th>Fecha Fin</th>--}}
                <th>Precio</th>
                <th>Pago Conductor</th>
                <th>Margen</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>¿Aceptó?</th>
                <th>Courier</th>
                {{--<th>Tipo de Pago</th>--}}
                {{--<th>Pagado?</th>--}}
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            @for( $i = 0; $i < count($req_company); $i++)
                <form action="update_data_company_request" method="post">
                    {{@csrf_field()}}
                    <input type="hidden" name="idRequestC" value="{{$req_company[$i]["id"]}}">
                    <tr>
                        <td>{{$req_company[$i]["id"]}}</td>
                        <td>
                            @foreach($companies as $company)
                                @if($req_company[$i]["company_id"] == $company->id)
                                    {{$company->r_social}}
                                @endif

                            @endforeach
                        </td>
                        <td>
                            @foreach($clients as $client)
                                @if($req_company[$i]["client_id"] == $client->id)
                                    {{$client->first_name}}  {{$client->last_name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <select class="form-control" name="provider_id" id="">
                            <option value="">Seleccione un Conductor</option>
                            @foreach($providers as $provider)
                                @foreach($car as $cr)
                                    @if($provider->id == $cr->idprovider)
                                        @if($req_company[$i]["id_type_car"] == $cr->type)
                                            <option value="{{$provider->id}}"
                                                    @if($provider->id == $req_company[$i]["provider_id"])
                                                    selected="selected"
                                                    @endif
                                            >{{$provider->first_name}}  {{$provider->last_name}}</option>

                                        @endif()
                                    @endif
                                @endforeach
                            @endforeach



                        </td >
                        <td>
                            @foreach($type_car as $t_car)
                                @if($req_company[$i]["id_type_car"] == $t_car->id)
                                    {{$t_car->type_c}}
                                @endif

                            @endforeach
                        </td>
                        <td>{{$req_company[$i]["date_arrive"]}}</td>
                        {{--<td>{{$req_company->date_request}}</td>--}}
                        {{--<td><input type="datetime-local"  width="50px" class="form-control" value="{{$request->date_arrive}}"  name="date_arrive"></td>--}}
                        {{--<td><input type="datetime-local"class="form-control"  value="{{$request->end}}"  name="date_end"></td>--}}

                        <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$req_company[$i]["cost_amount"]}}"></td>
                        <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$req_company[$i]["cost_provider"]}}"></td>
                        <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$req_company[$i]["margin"]}}"></td>
                        <td style="display: none;"><input type="hidden" size="10"  name="pTotal" {{ $req_company[$i]["pTotal"] }}  ></td>

                        <td>{{$req_company[$i]["start_address"]}}</td>
                        <td>{{$req_company[$i]["end_address"]}}</td>
                        <td style="text-align: center">
                            @if($req_company[$i]["status_request"] == 0)
                                <a href="{{route("change_state_request_company",[$req_company[$i]["id"]])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                            @else
                                <a href="{{route("change_state_request_company",[$req_company[$i]["id"]])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($req_company[$i]["is_courier"] == 0)

                                <a class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                            @else
                                <a class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                            @endif


                        </td>
                        {{--<td>--}}
                        {{--<select class="form-control" name="payment_type_id" id="">--}}
                        {{--<option value="">Tipo de Pago</option>--}}
                        {{--@foreach($payments as $payment)--}}
                        {{--<option value="{{$payment->id}}"--}}
                        {{--@if($request->payment_type_id == $payment->id)--}}
                        {{--selected="selected"--}}
                        {{--@endif--}}
                        {{-->{{$payment->type_payment}}</option>--}}

                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</td>--}}
                        {{--<td style="text-align: center">--}}
                            {{--@if($req_company[$i]["is_paint"]== 0)--}}
                                {{--<a  href="{{route("change_is_payment_request_company",[$req_company[$i]["id"]])}}"class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>--}}
                            {{--@else--}}
                                {{--<a href="{{route("change_is_payment_request_company",[$req_company[$i]["id"]])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>--}}
                            {{--@endif--}}

                        {{--</td>--}}
                        <td>
                            {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                            <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                            <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
{{--                            <a data-toggle="modal" data-target="#detailsRequestCompany" class="btn btn-info btn_details_request" id="{{$req_company[$i]["id"]}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>--}}
                            <a href="{{route("delete_request_company", [$req_company[$i]["id"]])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </form>
            @endfor
            </tbody>

            </tfoot>
        </table>
    </div>
@endsection

@section("after_scripts")
    <script>
        const cost_amount  = document.querySelectorAll(".cost_amount");
        const const_provide = document.querySelectorAll(".const_provide")

        for(let i = 0; i <  cost_amount.length; i++) {
            cost_amount[i].addEventListener("keyup", function () {
                // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                let costA = cost_amount[i].value
                let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP

                // console.log()
              cost_amount[i].parentElement.nextElementSibling.nextElementSibling.nextElementSibling.firstChild.value = costA

            })
            const_provide[i].addEventListener('keyup', function () {
                // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                let costA = cost_amount[i].value
                let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP


            })
        }

        let json_ids = JSON.parse('<?php echo $json_data ?>')
        const temp = () => {
            setTimeout( () => {
                    $.ajax( {
                    url: 'getDataForId',
                    data: {
                        json_ids: json_ids
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: (data) => {
                        console.log(data)
                    }
                })

            }, 1)
        };
        temp();
    </script>

    @endsection