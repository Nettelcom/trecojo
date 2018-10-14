
@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Solicitudes Empresa<small>Mostrar todas las solicitudes de empresas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">solicitudes</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Empresas</div>
                </div>

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
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>--}}
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>
            </div>
        </div>
        <!-- /.box-header -->
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
                    {{--<th>Fecha Recojo</th>--}}
                    {{--<th>Fecha Fin</th>--}}
                    <th>Estado</th>
                    <th>Precio Total</th>
                    <th>Pago Conductor</th>
                    <th>Margen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    {{--<th>Tipo de Pago</th>--}}
                    <th>Pagado?</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>

                @foreach($req_companies as $req_company)
                    <form action="update_data_company_request" method="post">
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequestC" value="{{$req_company->id}}">
                        <tr>
                            <td>{{$req_company->id}}</td>
                            <td>
                                @foreach($companies as $company)
                                    @if($req_company->company_id == $company->id)
                                        <span style="font-size: .9em;">{{$company->r_social}}</span>
                                    @endif

                                @endforeach
                            </td>
                            <td>
                                @foreach($clients as $client)
                                    @if($req_company->client_id == $client->id)
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
                                                @if($req_company->id_type_car == $cr->type)
                                                    <option value="{{$provider->id}}"
                                                            @if($provider->id == $req_company->provider_id)
                                                            selected="selected"
                                                            @endif
                                                    >{{$provider->first_name}}  {{$provider->last_name}}</option>

                                                @endif()
                                            @endif
                                        @endforeach
                                    @endforeach
                                    {{--@foreach($providers as $provider)--}}
                                        {{--<option value="{{$provider->id}}"--}}
                                                {{--@if($provider->id == $req_company->provider_id)--}}
                                                {{--selected="selected"--}}
                                                {{--@endif--}}
                                        {{-->{{$provider->first_name}}  {{$provider->last_name}}</option>--}}


                                    {{--@endforeach--}}
                                </select>

                            </td >
                            <td>
                                @foreach($type_car as $t_car)
                                    @if($req_company->id_type_car == $t_car->id)
                                        {{$t_car->type_c}}
                                    @endif

                                @endforeach
                            </td>
                            {{--<td>{{$req_company->date_request}}</td>--}}
                            {{--<td><input type="datetime-local"  width="50px" class="form-control" value="{{$request->date_arrive}}"  name="date_arrive"></td>--}}
                            {{--<td><input type="datetime-local"class="form-control"  value="{{$request->end}}"  name="date_end"></td>--}}
                            <td style="text-align: center">
                                @if($req_company->status_request == 0)
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                                @else
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif
                            </td>
                            <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$req_company->cost_amount}}"></td>
                            <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$req_company->cost_provider}}"></td>
                            <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$req_company->margin}}"></td>
                            <td>{{$req_company->start_address}}</td>
                            <td>{{$req_company->end_address}}</td>
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
                                @if($req_company->is_paint == 0)
                                    <a  href="{{route("change_is_payment_request_company",[$req_company->id])}}"class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>

                                @else
                                    <a href="{{route("change_is_payment_request_company",[$req_company->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif

                            </td>
                            <td>
                                {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                                <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                                <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
                                <a data-toggle="modal" data-target="#detailsRequestCompany" class="btn btn-info btn_details_request" id="{{$req_company->id}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>
                                <a href="{{route("delete_request_company", [$req_company->id])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </form>
                @endforeach
                </tbody>

                </tfoot>
            </table>
            {!! $req_companies->render() !!}
        </div>

    </div>





    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Courier Empresas</div>
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
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>--}}
            {{--</div>--}}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Cliente</th>
                    {{--<th>Usuario</th>--}}
                    <th>Conductor</th>
                    <th>Vehículo</th>
                    {{--<th>Fecha Pedido</th>--}}
                    {{--<th>Fecha Recojo</th>--}}
                    {{--<th>Fecha Fin</th>--}}
                    <th>Estado</th>
                    <th>Precio Total</th>
                    <th>Pago Conductor</th>
                    <th>Margen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    {{--<th>Tipo de Pago</th>--}}
                    <th>Pagado?</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>

                @foreach($req_couriers as $req_company)
                    <form action="update_data_company_request" method="post">
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequestC" value="{{$req_company->id}}">
                        <tr>
                            <td>{{$req_company->id}}</td>
                            <td>
                                @foreach($companies as $company)
                                    @if($req_company->company_id == $company->id)
                                        <span style="font-size: .9em;">{{$company->r_social}}</span>
                                    @endif

                                @endforeach
                            </td>
                            {{--<td>--}}
                                {{--@foreach($clients as $client)--}}
                                    {{--@if($req_company->client_id == $client->id)--}}
                                        {{--{{$client->first_name}}  {{$client->last_name}}--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--</td>--}}
                            <td>
                                <select class="form-control" name="provider_id" id="">
                                    <option value="">Seleccione un Conductor</option>
                                    @foreach($providers as $provider)
                                        @foreach($car as $cr)
                                            @if($provider->id == $cr->idprovider)
                                                @if($req_company->id_type_car == $cr->type)
                                                    <option value="{{$provider->id}}"
                                                            @if($provider->id == $req_company->provider_id)
                                                            selected="selected"
                                                            @endif
                                                    >{{$provider->first_name}}  {{$provider->last_name}}</option>

                                                @endif()
                                            @endif
                                        @endforeach
                                    @endforeach
                                    {{--@foreach($providers as $provider)--}}
                                    {{--<option value="{{$provider->id}}"--}}
                                    {{--@if($provider->id == $req_company->provider_id)--}}
                                    {{--selected="selected"--}}
                                    {{--@endif--}}
                                    {{-->{{$provider->first_name}}  {{$provider->last_name}}</option>--}}


                                    {{--@endforeach--}}
                                </select>

                            </td >
                            <td>
                                @foreach($type_car as $t_car)
                                    @if($req_company->id_type_car == $t_car->id)
                                        {{$t_car->type_c}}
                                    @endif

                                @endforeach
                            </td>
                            {{--<td>{{$req_company->date_request}}</td>--}}
                            {{--<td><input type="datetime-local"  width="50px" class="form-control" value="{{$request->date_arrive}}"  name="date_arrive"></td>--}}
                            {{--<td><input type="datetime-local"class="form-control"  value="{{$request->end}}"  name="date_end"></td>--}}
                            <td style="text-align: center">
                                @if($req_company->status_request == 0)
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                                @else
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif
                            </td>
                            <td><input type="text" size="10" class="cost_amount" name="cost_amount" value="{{$req_company->cost_amount}}"></td>
                            <td><input type="text" size="10" name="cost_provider" class="const_provide" value="{{$req_company->cost_provider}}"></td>
                            <td><input type="text" size="10" style="background: #ccc; border-radius: 5px" name="margin" readonly="readonly" value="{{$req_company->margin}}"></td>
                            <td>{{$req_company->start_address}}</td>
                            <td>{{$req_company->end_address}}</td>
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
                                @if($req_company->is_paint == 0)
                                    <a  href="{{route("change_is_payment_request_company",[$req_company->id])}}"class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>

                                @else
                                    <a href="{{route("change_is_payment_request_company",[$req_company->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif

                            </td>
                            <td>
                                {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                                <label for="save_data"><button class="btn btn-success" title="Grabar"><i class="fa fa-save"></i></button></label>
                                <input type="submit" value="Grabar" id="save_data" class="btn btn-success hidden">
                                <a data-toggle="modal" data-target="#detailsRequestCompany" class="btn btn-info btn_details_request" id="{{$req_company->id}}" title="Ver Detalles" ><i class="fa fa-plus"></i></a>
                                <a href="{{route("delete_request_company", [$req_company->id])}}" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </form>
                @endforeach
                </tbody>

                </tfoot>
            </table>
            {!! $req_companies->render() !!}
        </div>

    </div>






























    <!-- /.box-body -->
        <div class="modal fade" id="addCompanyRequest" tabindex="-1" role="dialog"
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
                            Agregar Solicitud Empresa
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">

                        <form class="form-horizontal" action="{{route('add_request_modal_company')}}" id="frm_client" method="post">
                            {{@csrf_field() }}
                            <input type="hidden" id="" name="idRequest">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3">Empresas Registradas</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="client_id" id="cb_company">
                                        <option value="">Clientes</option>
                                        @foreach($companies as $company)

                                            <option value="{{$company->id}}">{{$company->r_social}}</option>

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





                            <div class="form-group" id="hide_1">
                                <label  class="col-sm-2 control-label"
                                        for="inputEmail3">Usuario de Empresa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="user_id" id="user_cb">
                                        <option value="empty">Usuarios De Empresa</option>
                                        {{--<option value="">Tipo de Pago</option>--}}
                                        {{--@foreach($payments as $payment)--}}
                                            {{--<option class="" value="{{$payment->id}}">--}}
                                                {{--{{$payment->type_payment}}--}}
                                            {{--</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label  class="col-sm-2 control-label"--}}
                                        {{--for="inputEmail3">Otro Usuario</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<input type="text" name="other_user" class="form-control" id="other_user">--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--$type_car--}}

                            <div class="form-group" id="hide_2">
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

                            <div class="form-group" id="hide_3">
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

                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="inputEmail3">Tipo de Pago</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="payment_type_id" id="">
                                        <option value="">Tipo de Pago</option>
                                        @foreach($payments as $payment)
                                            <option class="" value="{{$payment->id}}">
                                                {{$payment->type_payment}}
                                            </option>
                                        @endforeach
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

    </div>
    {{-- MODAL--}}
    {{-- MODAL--}}
    <div class="modal fade" id="detailsRequestCompany" tabindex="-1" role="dialog"
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

                    <form class="form-horizontal" action="{{route('update_detail_request_company')}}" id="frm_client" method="post">
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
                                       id="date_request_detail" placeholder="Nueva Contraseña"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Fecha/Hora de embarque</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_arrive" class="form-control"
                                       id="date_arrive_detail" placeholder="Confirme Contraseña"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Fecha/Hora de Llegada</label>
                            <div class="col-sm-10">
                                <input type="datetime-local"  name="date_end" class="form-control"
                                       id="date_end_detail" placeholder="Confirme Contraseña"/>
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









    <div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Empresa</h4>

                </div>
                <div class="modal-body">
                    <div role="tabpanel">

                        <form class="form-horizontal" action="{{route('add_company')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idProvider" id="idProvider">
                        {{@csrf_field() }}
                        <!-- Nav tabs -->
                        {{--<ul class="nav nav-tabs" role="tablist">--}}
                        {{--<li role="presentation" class="active"><a href="#Conductor" aria-controls="uploadTab" role="tab" data-toggle="tab">Conductor</a>--}}

                        {{--</li>--}}
                        {{--<li role="presentation"><a href="#Auto" aria-controls="browseTab" role="tab" data-toggle="tab">Auto</a>--}}

                        {{--</li>--}}
                        {{--</ul>--}}
                        <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Conductor">
                                    {{--MODAL CONDUCTOR--}}
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Numero de RUC</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="ruc_number" class="form-control"
                                                       id="ruc_number" placeholder="Ingrese el número de RUC"/>
                                                <p id="response_ruc" style="color: red"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Razón social</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly  name="r_social" class="form-control"
                                                       id="r_social" placeholder="Nombre o Razón Social"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Estado</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly  name="estado" class="form-control"
                                                       id="estado" placeholder="Estado"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Departamento</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly  name="departamento" class="form-control"
                                                       id="departamento" placeholder="Departamento"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Provincia</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly name="provincia" class="form-control"
                                                       id="provincia" placeholder="Provincia"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Distrito</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly name="distrito" class="form-control"
                                                       id="distrito" placeholder="Distrito"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Dirección</label>
                                            <div class="col-sm-10">
                                                <input type="text" required readonly name="direccion" class="form-control"
                                                       id="direccion" placeholder="Direecion"/>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Nombres</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="first_name" class="form-control"
                                                       id="first_name" placeholder="Apellidos"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Apellidos</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="last_name" class="form-control"
                                                       id="last_name" placeholder="Apellidos"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Email</label>
                                            <div class="col-sm-10">
                                                <input type="text"  required name="email" class="form-control"
                                                       id="email" placeholder="Correo Electrónico"/>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label"--}}
                                        {{--for="inputPassword3" >Contraseña</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                        {{--<input type="password"  required name="pwd_company" class="form-control"--}}
                                        {{--id="email" placeholder="Contraseña"/>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label"--}}
                                        {{--for="inputPassword3" >Confirmar Contraseña</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                        {{--<input type="password"  required name="pwd_company_confirm" class="form-control"--}}
                                        {{--id="email" placeholder="Confirmar Contraseña"/>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Celular</label>
                                            <div class="col-sm-10">
                                                <input type="text"   name="phone" class="form-control"
                                                       id="phone" placeholder="Número de Celular"/>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label"--}}
                                        {{--for="inputPassword3" >Imagen</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                        {{--<input type="file"  name="picture" class="form-control"--}}
                                        {{--id="picture" placeholder="Asientos"/>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Estado</label>
                                        <div class="col-sm-10" >
                                            <input type="checkbox" style="position:relative;top:  5px;"  class="form-check-input" name="approval_status"
                                                   id="approval_status" />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                            Cerrar
                                        </button>
                                        <input type="submit" value="Registrar" id="btn_client" class="btn btn-primary">
                                    </div>
                        </form>
                    </div></div><</div></div></div>











                                    @endsection
@section('after_scripts')
    <script>
        const btn_details_request = document.querySelectorAll(".btn_details_request")
        const valid_type_payment = document.querySelectorAll('.valid_type_payment')
        for(let i = 0; i < btn_details_request.length; i++) {
            btn_details_request[i].addEventListener('click', function () {
                let idC = btn_details_request[i].id
                $.ajax({
                    url: 'get_request_company',
                    data: {idC: idC},
                    method: 'POST',
                    dataType: 'JSON',
                    success: function (data) {
                        for(let i = 0; i < valid_type_payment.length; i++) {
                            if(valid_type_payment[i].value == data[0].payment_type_id) {
                                valid_type_payment[i].selected = true
                            }
                        }
                        idRequest_detail.value = data[0].id

                        // payment_type_detail.value = data[0].payment_type_id
                        date_request_detail.value = data[0].date_request
                        date_arrive_detail.value = data[0].date_arrive
                        date_end_detail.value = data[0].date_end
                    }
                })
            })
        }

        const cost_amount  = document.querySelectorAll(".cost_amount");
        const const_provide = document.querySelectorAll(".const_provide")

        for(let i = 0; i <  cost_amount.length; i++) {
            cost_amount[i].addEventListener("keyup", function () {
                // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                let costA = cost_amount[i].value
                let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP

                // console.log()

            })
            const_provide[i].addEventListener('keyup', function () {
                // console.log(cost_amount[i].parentElement.nextElementSibling.firstChild.value)
                let costA = cost_amount[i].value
                let constP = cost_amount[i].parentElement.nextElementSibling.firstChild.value

                cost_amount[i].parentElement.nextElementSibling.nextElementSibling.firstChild.value = costA - constP

            })
        }
        ruc_number.addEventListener('blur', function () {
            $.ajax({
                url: 'consult_ruc',
                data: { ruc_value : ruc_number.value },
                dataType: 'JSON',
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function (data) {

                    if( data.success === false) {
                        response_ruc.textContent =  data.error
                        r_social.value = ""
                        departamento.value = ""
                        provincia.value = ""
                        distrito.value = ""
                        direccion.value = ""
                        estado.value = ""
                    }
                    if(data.success === true) {
                        r_social.value = data.nombre_o_razon_social
                        departamento.value = data.departamento
                        provincia.value = data.provincia
                        distrito.value = data.distrito
                        direccion.value = data.direccion_completa
                        estado.value = data.estado_del_contribuyente
                        response_ruc.textContent =  ""
                    }
                }

            })
        })
        cb_company.addEventListener("change", function () {
            let id_company = cb_company.value
            $.ajax({
                url: 'get_users_company',
                data: {id_company: id_company},
                dataType: 'JSON',
                method: 'POST',
                success: function (users) {
                    $("#user_cb").html(users.opts)



                }
            })
        })

        user_cb.addEventListener("change", function () {
            if (user_cb.value != "empty") {
                other_user.disabled = true
                other_user.value = ""
            }else {
                other_user.disabled = false
            }
        })
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
        courier.addEventListener('change', function () {
            if(courier.checked == true) {
                $("#hide_1").hide()

            }else {
                $("#hide_1").show()

            }
        })
    </script>
@endsection