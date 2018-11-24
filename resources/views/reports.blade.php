@extends('backpack::layout')

@section('header')

    <section class="content-header">
        <h1>Reportes</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Conductores</div>
                </div>

            </div>

        </div>
    </div>
    <div class="box">
        <div class="box-header" style="display: flex">

            <div style="margin-left: 10px">
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>--}}
                <form method="post" action="{{ route("report_clients") }}" class="form-inline">
                    {{ @csrf_field() }}
                <div class="form-group">
                    <label  class="col-sm-5 control-label"
                            for="inputEmail3">Conductores</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id_provider" id="">
                            <option value="">Conductores</option>
                            @foreach( $providers as $provider )
                                <option class="valid_type_payment" value="{{ $provider->id }}">
                                    {{ $provider->first_name }} {{ $provider->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div>

            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 1</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha1" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 2</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha2" class="form-control">
                </div>
            </div>
            <div class="form-group" style="display: flex; justify-content: center; align-items: center">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Generar Reporte">
                </div>
            </div>
        </form>


        </div>


    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" >
                <div class="box-header with-border">
                    <div class="box-title">Cliente Empresa</div>
                </div>

            </div>

        </div>

    </div>
    <div class="box">
        <div class="box-header" style="display: flex">

            <div style="margin-left: 10px">
                <form method="post" action="{{ route("report_company") }}" class="form-inline">
                    {{ @csrf_field() }}
                    <div class="form-group">
                        <label  class="col-sm-5 control-label"
                                for="inputEmail3">Empresas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_company" id="">
                                <option value="">Empresas</option>
                                @foreach( $companies as $company )
                                    <option class="valid_type_payment" value="{{ $company->id }}">
                                        {{ $company->r_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 1</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha1" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 2</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha2" class="form-control">
                </div>
            </div>
            <div class="form-group" style="display: flex; justify-content: center; align-items: center">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Generar Reporte">
                </div>
            </div>
            </form>


        </div>


    </div>

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

            <div style="margin-left: 10px">
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addClientRequest">Agregar como Persona</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompanyRequest">Agregar como Empresa</button>--}}
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>--}}
                <form method="post" action="{{ route("report_persona") }}" class="form-inline">
                    {{ @csrf_field() }}
                    <div class="form-group">
                        <label  class="col-sm-5 control-label"
                                for="inputEmail3">Clientes</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_client" id="">
                                <option value="">Clientes</option>
                                @foreach( $clients as $client)
                                    <option class="valid_type_payment" value="{{ $client->id }}">
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 1</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha1" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3">Fecha 2</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha2" class="form-control">
                </div>
            </div>
            <div class="form-group" style="display: flex; justify-content: center; align-items: center">
                <label  class="col-sm-5 control-label"
                        for="inputEmail3"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Generar Reporte">
                </div>
            </div>
            </form>


        </div>


    </div>

@endsection