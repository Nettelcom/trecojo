@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Pagos<small>Mostrar el estado de pagos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Pagos</li>
        
      </ol>

    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border" style="display: flex; justify-content:space-between">
                    <div class="box-title">Filtros</div>
                    <div class="box-default">
                        <form action="filter_payments" method="POST">
                            {{@csrf_field()}}
                            Fecha 1: <input type="date" name="date_1">
                            Fecha 2: <input type="date" name="date_2">
                            Tipo de Pago: <select name="type_payment" id="" >
                                <option value="">Seleccionar</option>
                                @foreach($payments as $payment)
                                    <option value="{{$payment->id}}">{{$payment->type_payment}}</option>
                                    @endforeach
                            </select>
                            <input type="submit" value="Buscar" class="btn btn-primary">


                        </form>
                    </div>
                    
                </div>


            </div>

        </div>
    </div>
                <div class="row">
        <div  class="col-lg-3 col-xs-5 buttons_payments" id="0">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>S/.{{$costs_amounts['all']}}</h3>

              <p>Pago Total</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 buttons_payments" id="1">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>S/.{{$costs_amounts['contado']}}<sup style="font-size: 20px"></sup></h3>

              <p>Contado</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 buttons_payments" id="2">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>S/.{{$costs_amounts['tarjeta']}}</h3>

              <p>Crédito</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 buttons_payments" id="3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>S/.{{$costs_amounts['otros']}}</h3>

              <p>Otros tipos de pagos</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Clientes Persona</div>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        {{--<div class="box-header">--}}
              {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                  {{--<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">--}}

                  {{--<div class="input-group-btn">--}}
                    {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}

                  {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#id</th>
                    <th>Embarque</th>
                    <th>Usuario</th>
                  <th>Conductor</th>
                  {{--<th>Estado</th>--}}
                  <th>Monto Totall</th>
                  <th>Pago Conductor</th>
                  <th>Margen</th>
                  {{--<th>Estado del pago</th>--}}
                  <th>Medio de pago</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    {{--<th>Fecha/Hora Solicitud</th>--}}
                    <th>Llegada</th>
                </tr>
                </thead>
                <tbody id="body_client">
                    @foreach($clientsL as $clientL)
                        <tr>
                            <td>{{$clientL->id}}</td>
                            <td>{{$clientL->date_arrive}}</td>

                            <td>
                            @foreach($clients_request as $client_request)
                                @if($client_request->id == $clientL->client_id)
                                    {{$client_request->first_name}}  {{$client_request->last_name}}
                                @endif

                            @endforeach
                            <td>
                                @foreach($providers as $provider)
                                    @if($provider->id == $clientL->provider_id)
                                         {{$provider->first_name}}  {{$provider->last_name}}
                                    @endif

                                @endforeach
                            </td>
                               <td >S/.{{$clientL->cost_amount}}</td>
                               <td >S/.{{$clientL->cost_provider}}</td>
                               <td >S/.{{$clientL->margin}}</td>
                            <td>
                                @foreach($payments as $payment)
                                    @if($payment->id == $clientL->payment_type_id)
                                        {{$payment->type_payment}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$clientL->start_address}}</td>
                            <td>{{$clientL->end_address}}</td>
                            {{--<td>{{$clientL->date_request}}</td>--}}
                            <td>{{$clientL->date_end}}</td>
                        </tr>
                    @endforeach
               </tbody>

                </tfoot>
              </table>
            </div>
    </div>
            <!-- /.box-body -->

        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">Cliente Empresas</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="box">
            {{--<div class="box-header">--}}
                {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                    {{--<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">--}}

                    {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}

                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#id</th>
                        <th>Embarque</th>

                        <th>Empresa</th>
                        <th>Conductor</th>
                        <th>Usuario</th>
                        {{--<th>Estado</th>--}}
                        <th>Monto Total</th>
                        <th>Pago Conductor</th>
                        <th>Margen</th>
                        {{--<th>Estado del pago</th>--}}
                        <th>Medio de pago</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        {{--<th>Fecha/Hora Solicitud</th>--}}
                        <th>Llegada</th>
                    </tr>
                    </thead>
                    <tbody id="body_company">
                    @foreach($companiesL as $companyL)
                        <tr>
                            <td>{{$companyL->id}}</td>
                            <td>{{$companyL->date_arrive}}</td>

                            <td>
                            @foreach($compas as $compa)
                                @if($compa->id == $companyL->company_id)
                                    {{$compa->r_social}}
                                @endif

                                @endforeach</td>

                            <td>
                                @foreach($providers as $provider)
                                    @if($provider->id == $companyL->provider_id)
                                        {{$provider->first_name}}  {{$provider->last_name}}
                                    @endif

                                @endforeach
                            </td>
                            <td>
                                @foreach($clients_request as $client)
                                    @if($client->id == $companyL->client_id)
                                        {{$client->first_name}}  {{$client->last_name}}
                                    @endif
                                @endforeach
                            </td>
                            <td >S/.{{$companyL->cost_amount}}</td>
                            <td >S/.{{$companyL->cost_provider}}</td>
                            <td >S/.{{$companyL->margin}}</td>
                            <td>
                                @foreach($payments as $payment)
                                    @if($payment->id == $companyL->payment_type_id)
                                        {{$payment->type_payment}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$companyL->start_address}}</td>
                            <td>{{$companyL->end_address}}</td>
                            {{--<td>{{$companyL->date_request}}</td>--}}
                            <td>{{$companyL->date_end}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                    </tfoot>
                </table>
            </div>
           
          </div>
@endsection
@section('after_scripts')
    <script>
       const buttons_payments = document.querySelectorAll(".buttons_payments")
        for(let i = 0; i < buttons_payments.length; i++) {
            buttons_payments[i].addEventListener('click', function () {
                let typePayment =  buttons_payments[i].id
                $.ajax({
                    url: 'get_payments_for_type',
                    data: {type: typePayment},
                    method: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $("#body_client").html("")
                        $("#body_client").html(data.client_html)
                        $("#body_company").html("")
                        $("#body_company").html(data.company_html)
                    }
                })
            })

        }




    </script>


@endsection