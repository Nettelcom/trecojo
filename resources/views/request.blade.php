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
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Solicitudes</div>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
              <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
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
                  <th>Fecha/Hora</th>
                  <th>Estado</th>
                  <th>Precio</th>
                  <th>Tipo de Pago</th>
                  <th>Cancelado?</th>
                  <th>Opciones</th>
                </tr>
                </thead>
                <tbody>

                @foreach($req as $request)
                    <form action="update_data_request" method="post">
                        {{@csrf_field()}}
                        <input type="hidden" name="idRequest" value="{{$request->id}}">
                <tr>
                    <td>{{$request->id}}</td>
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
                                <option value="{{$provider->id}}"
                                @if($provider->id == $request->provider_id)
                                        selected="selected"
                                        @endif
                                >{{$provider->first_name}}  {{$provider->last_name}}</option>


                         @endforeach
                        </select>

                    </td>
                    <td>{{$request->date_request}}</td>
                    <td>
                        @if($request->status_request == 0)
                            <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-danger">En curso</a>
                         @else
                            <a href="{{route("change_state_request",[$request->id])}}" class="btn btn-success">Terminado</a>
                        @endif
                    </td>
                    <td><input type="text" name="cost_amount" value="{{$request->cost_amount}}"></td>
                    <td>
                        <select class="form-control" name="payment_type_id" id="">
                            <option value="">Tipo de Pago</option>
                                @foreach($payments as $payment)
                                <option value="{{$payment->id}}"
                                    @if($request->payment_type_id == $payment->id)
                                        selected="selected"
                                     @endif
                                >{{$payment->type_payment}}</option>

                                @endforeach
                        </select>
                    </td>
                    <td>
                        @if($request->is_paint == 0)
                            <a href="{{route("change_is_payment_request",[$request->id])}}" class="btn btn-danger">No</a>
                        @else
                            <a href="{{route("change_is_payment_request",[$request->id])}}"class="btn btn-success">Si</a>
                        @endif

                    </td>
                    <td>
                        {{--<button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" ><i class="fa fa-edit"></i> Grabar</button>--}}
                        <input type="submit" value="Grabar" class="btn btn-success">
                        <a href="{{route("delete_request", [$request->id])}}" class="btn btn-danger" ><i class="fa fa-edit"></i> Eliminar</a> </td>
                    </td>
                </tr>
                    </form>
                @endforeach
               </tbody>

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
           
          </div>
@endsection

