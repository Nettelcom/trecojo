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
                    <th>Fecha Pedido</th>
                    {{--<th>Fecha Recojo</th>--}}
                    {{--<th>Fecha Fin</th>--}}
                    <th>Estado</th>
                    <th>Precio</th>
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
                                        {{$company->r_social}}
                                    @endif

                                @endforeach
                            </td>
                            <td><select class="form-control" name="provider_id" id="">
                                    <option value="">Seleccione un Conductor</option>
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}"
                                                @if($provider->id == $req_company->provider_id)
                                                selected="selected"
                                                @endif
                                        >{{$provider->first_name}}  {{$provider->last_name}}</option>


                                    @endforeach
                                </select>

                            </td >
                            <td>{{$req_company->date_request}}</td>
                            {{--<td><input type="datetime-local"  width="50px" class="form-control" value="{{$request->date_arrive}}"  name="date_arrive"></td>--}}
                            {{--<td><input type="datetime-local"class="form-control"  value="{{$request->end}}"  name="date_end"></td>--}}
                            <td style="text-align: center">
                                @if($req_company->status_request == 0)
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-cogs"></i></a>
                                @else
                                    <a href="{{route("change_state_request_company",[$req_company->id])}}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                @endif
                            </td>
                            <td><input type="text" size="10" name="cost_amount" value="{{$req_company->cost_amount}}"></td>
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
                                    <a href="{{route("change_is_payment_request_company",[$req_company->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>
                                @else
                                    <a  href="{{route("change_is_payment_request_company",[$req_company->id])}}"class="btn btn-success btn-xs"><i class="fa fa-remove"></i></a>
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
                                    <select class="form-control" name="client_id" id="">
                                        <option value="">Clientes</option>
                                        @foreach($companies as $company)

                                            <option value="{{$company->id}}">{{$company->r_social}}</option>

                                        @endforeach
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
                        console.log(data)
                        idRequest_detail.value = data[0].id
                        // payment_type_detail.value = data[0].payment_type_id
                        date_request_detail.value = data[0].date_request
                        date_arrive_detail.value = data[0].date_arrive
                        date_end_detail.value = data[0].date_end
                    }
                })
            })
        }
    </script>
@endsection