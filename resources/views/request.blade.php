@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Solicitudes<small>Mostrar todas las solicitudes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">solicitudes</li>
      </ol>
    </section>
@endsection


@section('content')
    <style>
        .ocultar_btn {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Personas</div>

                </div>
                @if (\Session::has('fail'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('fail') !!}</li>
                        </ul>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <div class="box">
        <div class="box-header" style="display: flex">
              <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>

                </div>
            <div style="margin-left: 10px">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addClient">Agregar Cliente</button>
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" style="width: 100%; text-align: center" class="table table-striped">
                <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Conductor</th>
                  <th>Vehículo</th>
                    <th>Precio Total</th>
                    <th>Valor</th>
                    <th>Pago Conductor</th>
                    <th>Margen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Aceptado?</th>
                  <th>Pagado?</th>
                  <th>Opciones</th>
                </tr>
                </thead>
                <tbody id="body_client">
                @foreach($req as $request)
                    <form action="update_data_request" method="post">
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequest" value="{{$request->id}}">
                <tr>
                    <td>
                            @foreach($clients as $client)
                                @if($request->client_id == $client->id)
                                    {{$client->first_name}}  {{$client->last_name}}
                                 @endif

                            @endforeach
                    </td>
                    <td><select class="form-control" name="provider_id" id="">
                            <option value="">Seleccione un Conductor</option>
                        @foreach($providers as $provider)
                                            @foreach($car as $cr)
                                                @if($provider->id == $cr->idprovider)
                                                    @if($request->id_type_car == $cr->type)
                                                        <option value="{{$provider->id}}"
                                                                @if($provider->id == $request->provider_id)
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
                            @if($request->id_type_car == $t_car->id)
                                {{$t_car->type_c}}
                            @endif

                        @endforeach
                    </td>
                    <td style="display: none"><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="pTotal" readonly="readonly" value="{{$request->pTotal}}"></td>
                    <td><strong>{{$request->pTotal}}</strong></td>
                    <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$request->cost_amount}}"></td>
                    <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$request->cost_provider}}"></td>
                    <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$request->margin}}"></td>
                    <td>{{$request->start_address}}</td>
                    <td>{{$request->end_address}}</td>
                    <td style="text-align: center">
                        @if($request->status_request == 0)
                            <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                        @else
                            <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($request->is_paint == 0)
                            <a href="{{route("change_is_payment_request",[$request->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                        @else
                            <a href="{{route("change_is_payment_request",[$request->id])}}"class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                        @endif

                    </td>
                    <td>
                        <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                        <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
                        <a data-toggle="modal" data-target="#detailsRequest" class="btn btn-info btn_details_request" id="{{$request->id}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>
                        <a href="{{route("delete_request", [$request->id])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                    </form>
                @endforeach
               </tbody>

                </tfoot>
              </table>
            </div>
        <div class="box-footer clearfix">
            {!! $req->render() !!}
        </div></div>
            <!-- /.box-body -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Courier Personas</div>
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
            {{--<div style="margin-left: 10px">--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClient">Agregar Cliente</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
            {{--</div>--}}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    {{--<th>#id</th>--}}
                    <th>Cliente</th>
                    <th>Conductor</th>
                    <th>Vehículo</th>
                    {{--<th>Fecha Recojo</th>--}}
                    {{--<th>Fecha Fin</th>--}}
                    <th>Precio Total</th>
                    <th>Valor</th>
                    <th>Pago Conductor</th>
                    <th>Margen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Aceptado</th>
                    {{--<th>Tipo de Pago</th>--}}
                    <th>Pagado?</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody id="body_client">

                @foreach($req_courier as $request)
                    <form action="update_data_request" method="post">
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequest" value="{{$request->id}}">
                        <tr>
                            {{--<td>{{$request->id}}</td>--}}
                            <td>
                                @foreach($clients as $client)
                                    @if($request->client_id == $client->id)
                                        {{$client->first_name}}  {{$client->last_name}}
                                    @endif

                                @endforeach
                            </td>
                            <td><select class="form-control" name="provider_id" id="">
                                    <option value="">Seleccione un Conductor</option>
                                    @foreach($providers as $provider)
                                        @foreach($car as $cr)
                                            @if($provider->id == $cr->idprovider)
                                                @if($request->id_type_car == $cr->type)
                                                    <option value="{{$provider->id}}"
                                                            @if($provider->id == $request->provider_id)
                                                            selected="selected"
                                                            @endif
                                                    >{{$provider->first_name}}  {{$provider->last_name}}</option>

                                                @endif()
                                            @endif
                                        @endforeach
                                        {{--<option value="{{$provider->id}}"--}}
                                        {{--@if($provider->id == $request->provider_id)--}}
                                        {{--selected="selected"--}}
                                        {{--@endif--}}
                                        {{-->{{$provider->first_name}}  {{$provider->last_name}}</option>--}}


                                    @endforeach
                                </select>

                            </td>
                            <td>
                                @foreach($type_car as $t_car)
                                    @if($request->id_type_car == $t_car->id)
                                        {{$t_car->type_c}}
                                    @endif

                                @endforeach
                            </td>
                            {{--<td><input type="datetime-local"  width="50px" class="form-control" value="{{$request->date_arrive}}"  name="date_arrive"></td>--}}
                            {{--<td><input type="datetime-local"class="form-control"  value="{{$request->end}}"  name="date_end"></td>--}}

                            <td>{{ $request->pTotal }}</td>
                            <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$request->cost_amount}}"></td>
                            <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$request->cost_provider}}"></td>
                            <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$request->margin}}"></td>
                            <td style="display: none"><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="pTotal" readonly="readonly" value="{{$request->pTotal}}"></td>

                            <td>{{$request->start_address}}</td>
                            <td>{{$request->end_address}}</td>
                            <td style="text-align: center">
                                @if($request->status_request == 0)
                                    <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                                @else
                                    <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
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
                            <td style="text-align: center">
                                @if($request->is_paint == 0)
                                    <a href="{{route("change_is_payment_request",[$request->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                                @else
                                    <a href="{{route("change_is_payment_request",[$request->id])}}"class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif

                            </td>
                            <td>
                                {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                                <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                                <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
                                <a data-toggle="modal" data-target="#detailsRequest" class="btn btn-info btn_details_request" id="{{$request->id}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>
                                <a href="{{route("delete_request", [$request->id])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </form>
                @endforeach
                </tbody>

                </tfoot>
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! $req->render() !!}
        </div></div>

























          </div>
    <div class="modal fade" id="detailsRequest" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Detalle Solicitud
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="{{route('update_detail_request')}}" id="frm_client" method="post">
                        {{@csrf_field() }}
                        <input type="hidden" id="idRequest_detail" name="idRequest">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Tipo de Pago</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="payment_type_id" id="">
                                <option value="">Tipo de Pago</option>
                                @foreach($payments as $payment)
                                    <option class="valid_type_payment" value="{{$payment->id}}">
                                        {{$payment->type_payment}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Fecha/Hora Pedido</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_request" class="form-control"
                                       id="date_request_detail" placeholder="Hora Pedido"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Fecha/Hora de embarque</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_arrive" class="form-control"
                                       id="date_arrive_detail" placeholder="Hora Embarque"/>
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Fecha/Hora de Llegada</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_end" class="form-control"
                                       id="date_end_detail" placeholder="Hora Llegada"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Peaje</label>
                            <div class="col-sm-10">
                                <input type="text"  name="peaje" class="form-control"
                                       id="peaje" placeholder="Peaje"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Parqueo</label>
                            <div class="col-sm-10">
                                <input type="text"  name="parqueo" class="form-control"
                                       id="parqueo" placeholder="Parqueo"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Tiempo de Espera</label>
                            <div class="col-sm-10" >
                                <input type="text"  name="tespera" class="form-control"
                                       id="tespera" placeholder="Tiempo de Espera"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Destino   </label>

                            <div class="col-sm-8" id="div_content">
                                {{--<div class="col-sm-12" >--}}
                                <table id="tbl_paradas" class="table table-striped">
                                    <tr class="paradas">
                                        <td> <input type="text"  name="paradas[]" class="form-control"
                                                    id="parada" placeholder="Agregar una Destino" /></td>
                                        <td><button class="btn btn-danger delete_parada ocultar_btn"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                </table>
                         </div>
                                              {{--<div class="col-sm-2">--}}
                            {{--<button class="btn btn-danger btn-sm" id="delete_parada"><i class="fa fa-trash"></i></button>--}}


                                <button class="btn btn-primary btn-sm" id="add_input_destino"><i class="fa fa-plus"></i></button>
                            </div>
                        {{--</div>--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Observaciones:</label>
                            <div class="col-sm-8" >
                                <textarea name="obs" id="obs" cols="5"   rows="10" class="form-control"></textarea>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <input type="submit" value="Actualizar" id="btn_client" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- Modal Footer -->

            </div>
        </div>
    </div>
    {{--FIN MODAL--}}
    {{--CLIENTE MODAL ADD--}}
    {{--CLIENTE MODAL ADD--}}
    {{--CLIENTE MODAL ADD--}}



    <div class="modal fade" id="addClientRequest" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Agregar Solicitud Persona
                    </h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="{{route('add_request_modal_client')}}" id="frm_client" method="post">
                        {{@csrf_field() }}
                        {{--<input type="hidden" id="idRequest_detail" name="idRequest">--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Clientes Registrados</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="client_id" id="cb_client">
                                    <option value="">Clientes</option>
                                    @foreach($clients as $client)

                                        <option value="{{$client->id}}">{{$client->first_name}}   {{$client->last_name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Courier</label>
                            <div class="col-sm-10">
                                <input type="checkbox" class="checkbox"  id="courier"  name="is_courier" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Tipo de Pago</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="payment_type_id" id="cb_payment">
                                    <option value="">Tipo de Pago</option>
                                    {{--@foreach($payments as $payment)--}}
                                        {{--<option class="valid_type_payment" value="{{$payment->id}}">--}}
                                            {{--{{$payment->type_payment}}--}}
                                        {{--</option>--}}
                                    {{--@endforeach--}}
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Tipo de Vehículo</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="id_type_car" id="type_car">
                                    <option value="">Tipo de Vehículo</option>
                                    @foreach($type_car as $tipe_c)
                                        <option class="" value="{{$tipe_c->id}}">
                                            {{$tipe_c->type_c}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Conductores</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="provider_id" id="providers_cb">
                                    <option value="">Conductores</option>
                                    {{--@foreach($type_car as $tipe_c)--}}
                                    {{--<option class="" value="{{$tipe_c->id}}">--}}
                                    {{--{{$tipe_c->type_c}}--}}
                                    {{--</option>--}}
                                    {{--@endforeach--}}
                                </select>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3" >Fecha/Hora Pedido</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<input type="datetime-local"  name="date_request" class="form-control"--}}
                        {{--id="date_request_detail" placeholder="Nueva Contraseña"/>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Origen</label>
                            <div class="col-sm-10">
                                <input type="text"  name="start_address" class="form-control"
                                       placeholder="Origen"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Destino</label>
                            <div class="col-sm-10">
                                <input type="text"  name="end_address" class="form-control"
                                       placeholder="Destino"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Fecha/Hora de embarque</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_arrive" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3">Fecha/Hora de Llegada</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<input type="datetime-local"  name="date_end" class="form-control"--}}
                        {{--id="date_end_detail" placeholder="Confirme Contraseña"/>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <input type="submit" value="Registrar" id="btn_client" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- Modal Footer -->

            </div>
        </div>
    </div>
    {{--FIN MODAL--}}
    {{--ADD SOLICITD EMPRESA--}}
    {{--ADD SOLICITD EMPRESA--}}
    {{--ADD SOLICITD EMPRESA--}}














    {{--EMPRESAS--}}
    {{--EMPRESAS--}}
    {{--EMPRESAS--}}
    {{--EMPRESAS--}}


    <div class="modal fade" id="addClient" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Agregar Cliente
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="{{route('add_clients')}}" id="frm_client" method="post">
                        {{@csrf_field() }}
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"  name="first_name" class="form-control"
                                       placeholder="Nombre"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Apellidos</label>
                            <div class="col-sm-10">
                                <input type="text"  name="last_name" class="form-control"
                                       placeholder="Apellidos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Número de DNI</label>
                            <div class="col-sm-10">
                                <input type="text"  id="dni" name="dni"  maxlength="8" class="form-control"
                                       placeholder="DNI"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Teléfono</label>
                            <div class="col-sm-10">
                                <input type="text"  name="phone" class="form-control"
                                       placeholder="Teléfono"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Email</label>
                            <div class="col-sm-10">
                                <input type="text"  name="email" class="form-control"
                                       placeholder="Correo Electrónico"/>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3" >Contraseña</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<input type="text"  name="pwd_client" class="form-control"--}}
                        {{--placeholder="Contraseña"/>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3" >Confirmar Contraseña</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<input type="text"  name="confirm_pwd" class="form-control"--}}
                        {{--placeholder="Confirmar Contraseña"/>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Departamento</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="departamento" class="form-control"--}}
                                       {{--placeholder="Departamento"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Provincia</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="provincia" class="form-control"--}}
                                       {{--placeholder="Provincia"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Distrito</label>
                            <div class="col-sm-10">
                                <input type="text"  name="distrito" class="form-control"
                                       placeholder="Distrito"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Dirección</label>
                            <div class="col-sm-10">
                                <input type="text"  name="address" class="form-control "  placeholder="Dirección"/>
                            </div>
                        </div>



                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3" >Asientos</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<input type="text"  name="seat_capacity" class="form-control"--}}
                        {{--id="inputPassword3" placeholder="Asientos"/>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <input type="submit" value="Registrar" id="btn_client" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- Modal Footer -->

            </div>
        </div>
    {{--FIN MODAL--}}

@endsection

@section('after_scripts')

    <script>
        const btn_details_request = document.querySelectorAll('.btn_details_request')
        const valid_type_payment = document.querySelectorAll(".valid_type_payment")

        for(let i = 0; i < btn_details_request.length; i++) {
            btn_details_request[i].addEventListener('click', function () {
                $(".paradas:eq(0)").children("td").children("input").val(null)
                $(".paradas").not(":eq(0)").remove()
                let idRequest = btn_details_request[i].id
                $.ajax({
                    url: 'details_request',
                    data: {idRequest: idRequest},
                    dataType: 'JSON',
                    method: 'POST',
                    success: function (data) {


                        console.log(data[0].paradas)

                        // console.log(data)
                        for(let i = 0; i < valid_type_payment.length; i++) {
                            if(valid_type_payment[i].value == data[0].payment_type_id){
                                valid_type_payment[i].selected = true
                            }
                        }
                        idRequest_detail.value = data[0].id
                        // payment_type_detail.value = data[0].payment_type_id
                        date_request_detail.value = data[0].date_request
                        date_arrive_detail.value = data[0].date_arrive
                        date_end_detail.value = data[0].date_end
                        tespera.value = data[0].tespera
                        parqueo.value = data[0].parqueo
                        peaje.value = data[0].peaje
                        obs.value = data[0].obs
                        let arrParadas
                        if (data[0].paradas != "vacio") {
                            arrParadas = JSON.parse(data[0].paradas)
                            parada.value = arrParadas[0]
                            for(let i = 1; i < arrParadas.length; i++) {
                                const element_tr =  $("#tbl_paradas tbody tr:eq(0)").clone().appendTo("#tbl_paradas");
                                element_tr.children("td").children("button").css({"display":"block"})
                                element_tr.children("td").children("input").val(arrParadas[i])
                            }
                        }else {
                            $(".paradas:eq(0)").children("td").children("input").val(null)
                            $(".paradas").not(":eq(0)").remove()
                        }
                    }
                })
            })
        }
        $('#detailsRequest').on('hidden.bs.modal', function () {
            idRequest_detail.value = ""
            date_request_detail.value = ""
            date_arrive_detail.value = ""
            date_end_detail.value = ""

        });
        $('#addClientRequest').on('hidden.bs.modal', function () {
            idRequest_detail.value = ""
            date_request_detail.value = ""
            date_arrive_detail.value = ""
            date_end_detail.value = ""

        });

        const cost_amount  = document.querySelectorAll(".cost_amount");
        const const_provide = document.querySelectorAll(".const_provide")

        for(let i = 0; i <  cost_amount.length; i++) {
            cost_amount[i].addEventListener("keyup", function () {
                // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                let costA = cost_amount[i].value
                let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP
                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.nextElementSibling.firstChild.value = costA

               // console.log()

            })
            const_provide[i].addEventListener('keyup', function () {
                    // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                    let costA = cost_amount[i].value
                    let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                    cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP

                })


        }
        type_car.addEventListener("change", function () {
            $.ajax({
                url: "get_provider_data",
                data: {idCar: type_car.value},
                method: 'POST',
                dataType: "JSON",
                success: function (data) {
                    $("#providers_cb").html("")
                    $("#providers_cb").html(data.opts)
                }
            })
        })

        add_input_destino.addEventListener("click", function (e) {
            e.preventDefault()
            // alert("fds")
        const element_tr =    $("#tbl_paradas tbody tr:eq(0)").clone().appendTo("#tbl_paradas");
            element_tr.children("td").children("button").css({"display":"block"})
            element_tr.children("td").children("input").val("")
        });

        $(document).on("click",".delete_parada",function(e){
            e.preventDefault()
            const tr_parent = $(this).parents("tr").get(0)
            tr_parent.remove()
        });


        cb_client.addEventListener("change", function () {
                $.ajax({
                    url: "get_type_user",
                    data: {id: cb_client.value},
                    dataType: "JSON",
                    method: "GET",
                    success: function (data) {
                        $("#cb_payment").html("")
                        $("#cb_payment").html(data.html)

                    }
                })
        })


    </script>

@endsection