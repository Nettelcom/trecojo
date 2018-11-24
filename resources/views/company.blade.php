@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Empresas<small>Mostrar todas la empresas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Todos</li>
        </ol>
    </section>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Empresas</div>
                </div>
                @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{!! $error!!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul>
                            <li>{{session('success')}}</li>
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>
            </div></div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Nombre</th>
                    <th>RUC</th>
                    <th>Razón Social</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Direccion</th>
                    {{--<th>Estado</th>--}}
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
            {{--{{dump($companies)}}--}}
                @foreach($companies as $company)
                    <tr>
                        <td>{{$company->id}}</td>
                        <td>{{$company->first_name }} {{$company->last_name }}</td>
                        <td>{{$company->ruc }}</td>
                        <td><span style="font-size: .9em;">{{$company->r_social }}</span></td>
                        <td>{{$company->email }}</td>
                        <td>{{$company->phone}}</td>
                        <td>{{$company->address }}</td>
                        {{--<td><a class="imgProvider" id="{{$company->id}}" data-toggle="modal" data-target="#popUpImg">Ver Imagen</a></td>--}}

                        <td> <div class="input-group-btn">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones
                                    <span class="fa fa-caret-down"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a data-target="#addCompanyUser" id="{{$company->id}}" class="addUSerc" data-toggle="modal">Agregar Usuario</a></li>
                                    <li><a  class="btn_edit btnEditCompany"  data-toggle="modal" id="{{$company->id}}" data-target="#updateCompany" href="">Editar</a></li>

                                    <li>
                                        <a data-target="#CompanyTypePayments" id="{{$company->id}}" class="addUSerc type_payment" data-toggle="modal">
                                            Agregar Tipo de Pago
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="{{route('delete_company', [$company->id])}}">Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $companies ->render() !!}
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Cliente Empresas Pendiente</div>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header" style="display: flex">
            <div class="input-group input-group-sm" style="width: 150px;">
                {{--<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">--}}

                <div class="input-group-btn">
                    {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
                </div>
            </div>
            <div style="margin-left: 10px">
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#addCompany">Agregar Empresa</button>--}}
            </div></div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Nombre</th>
                    <th>RUC</th>
                    <th>Razón Social</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Direccion</th>
                    {{--<th>Estado</th>--}}
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                {{--{{dump($companies)}}--}}
                @foreach($pendients as $company)
                    <tr>
                        <td>{{$company->id}}</td>
                        <td>{{$company->first_name }} {{$company->last_name }}</td>
                        <td>{{$company->ruc }}</td>
                        <td><span style="font-size: .9em;">{{$company->r_social }}</span></td>
                        <td>{{$company->email }}</td>
                        <td>{{$company->phone}}</td>
                        <td>{{$company->address }}</td>

                        <td>
                            <a href="{{route("approval_status_company", [$company->id])}}" class="btn btn-xs btn-success" title="Aceptar Solicitud"><i class="fa fa-check"></i></a>

                            {{--<div class="input-group-btn">--}}

                                {{--<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones--}}
                                    {{--<span class="fa fa-caret-down"></span></button>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a data-target="#addCompanyUser" id="{{$company->id}}" class="addUSerc" data-toggle="modal">Agregar Usuario</a></li>--}}
                                    {{--<li><a  class="btn_edit btnEditCompany"  data-toggle="modal" id="{{$company->id}}" data-target="#updateCompany" href="">Editar</a></li>--}}
                                    {{--<li class="divider"></li>--}}
                                    {{--<li><a href="{{route('delete_company', [$company->id])}}">Eliminar</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>

                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $companies ->render() !!}
        </div>
    </div>











    {{--MODAL EMPRESA--}}
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


                                    {{--</div>--}}

                                <!-- Modal Footer -->
                                    {{--FIN MODAL CONDUCTOR--}}



                                    {{--FIN MODAL AUTO--}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                                <input type="submit" value="Registrar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div></div>
    <div class="modal fade" id="updateCompany" tabindex="-1" role="dialog"
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
                        Agregar Autos de Empresa
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="{{route('update_company')}}" method="post">
                        <input type="hidden" id="idCompany" name="idCompany">
                        {{@csrf_field() }}
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Numero de RUC</label>
                            <div class="col-sm-10">
                                <input type="text" required name="ruc_number" class="form-control"
                                       id="ruc_number_edit" placeholder="Ingrese el número de RUC"/>
                                <p id="response_ruc_update" style="color: red"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Razón social</label>
                            <div class="col-sm-10">
                                <input type="text" required readonly  name="r_social" class="form-control"
                                       id="r_social_update" placeholder="Nombre o Razón Social"/>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label   class="col-sm-2 control-label"--}}
                                     {{--for="inputEmail3">Estado</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text" required readonly  name="estado" class="form-control"--}}
                                       {{--id="estado_update" placeholder="Estado"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Departamento</label>
                            <div class="col-sm-10">
                                <input type="text" required readonly  name="departamento" class="form-control"
                                       id="departamento_update" placeholder="Departamento"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Provincia</label>
                            <div class="col-sm-10">
                                <input type="text" required readonly name="provincia" class="form-control"
                                       id="provincia_update" placeholder="Provincia"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Distrito</label>
                            <div class="col-sm-10">
                                <input type="text" required readonly name="distrito" class="form-control"
                                       id="distrito_update" placeholder="Distrito"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label   class="col-sm-2 control-label"
                                     for="inputEmail3">Dirección</label>
                            <div class="col-sm-10">
                                <input type="text" required readonly name="direccion" class="form-control"
                                       id="direccion_update" placeholder="Direecion"/>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Nombres</label>
                            <div class="col-sm-10">
                                <input type="text" required name="first_name" class="form-control"
                                       id="first_name_update" placeholder="Apellidos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Apellidos</label>
                            <div class="col-sm-10">
                                <input type="text" required name="last_name" class="form-control"
                                       id="last_name_update" placeholder="Apellidos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Email</label>
                            <div class="col-sm-10">
                                <input type="text"  required name="email" class="form-control"
                                       id="email_update" placeholder="Correo Electrónico"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Celular</label>
                            <div class="col-sm-10">
                                <input type="text"   name="phone" class="form-control"
                                       id="phone_update" placeholder="Número de Celular"/>
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
                                   id="approval_status_update" />
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Cerrar
                            </button>
                            <input type="submit" value="Actualizar" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- Modal Footer -->

            </div>
        </div>
    </div>
    {{--FIN MODAL--}}



    <div class="modal fade" id="addCompanyUser" tabindex="-1" role="dialog"
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

                    <form class="form-horizontal" action="{{route('add_clients_company')}}" id="frm_client" method="post">
                        {{@csrf_field() }}
                        <input type="hidden" id="idComp" name="id_company">
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
                                       placeholder="Correo Elenctrónico"/>
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
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Departamento</label>
                            <div class="col-sm-10">
                                <input type="text"  name="departamento" class="form-control"
                                       placeholder="Departamento"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Provincia</label>
                            <div class="col-sm-10">
                                <input type="text"  name="provincia" class="form-control"
                                       placeholder="Provincia"/>
                            </div>
                        </div>
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
                                <input type="text"  name="address" class="form-control"
                                       placeholder="Dirección"/>
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
    </div>

    <div class="modal fade" id="CompanyTypePayments" tabindex="-1" role="dialog"
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

                </div>
                <div class="modal-body">
                <!-- Modal Body -->
                <h4 class="modal-title" id="myModalLabel">
                    Tipo de Pago Relacionados
                </h4>
                <table  class="table table-striped">
                    <th>Empresas</th>
                    <th>Quitar</th>
                    <tbody id="myPaymets">

                    </tbody>
                </table>



                <h4 class="modal-title" id="myModalLabel">
                    Agregar Tipos de Pago
                </h4>
                <table  class="table table-striped">
                    <th>Empresas</th>
                    <th>Agregar</th>
                    <tbody id="noPaymets">

                    </tbody>
                </table>







                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        Cerrar
                    </button>
                    <input type="submit" value="Agregar"  class="btn btn-primary">

                </div>

            </div>


        </div>
    </div>




@endsection

@section('after_scripts')

                    <script>
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
                        ruc_number_edit.addEventListener('blur', function () {
                            $.ajax({
                                url: 'consult_ruc',
                                data: { ruc_value : ruc_number_edit.value },
                                dataType: 'JSON',
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                success: function (data) {

                                    if( data.success === false) {
                                        response_ruc_update.textContent =  data.error
                                        r_social_update.value = ""
                                        departamento_update.value = ""
                                        provincia_update.value = ""
                                        distrito_update.value = ""
                                        direccion_update.value = ""
                                        // estado_update.value = ""
                                    }
                                    if(data.success === true) {
                                        r_social_update.value = data.nombre_o_razon_social
                                        departamento_update.value = data.departamento
                                        provincia_update.value = data.provincia
                                        distrito_update.value = data.distrito
                                        direccion_update.value = data.direccion_completa
                                        // estado_update.value = data.estado_del_contribuyente
                                        response_ruc_update.textContent =  ""
                                    }
                                }

                            })
                        })
                        const btnEditCompany = document.querySelectorAll(".btnEditCompany")
                        for(let i = 0; i < btnEditCompany.length; i ++) {
                            btnEditCompany[i].addEventListener('click', function () {
                                idCompany.value = btnEditCompany[i].id
                                let idCom = btnEditCompany[i].id
                                $.ajax({
                                    url: 'show_edit_company',
                                    data: {idCom: idCom},
                                    method: 'POST',
                                    dataType: 'JSON',
                                    success: function (data) {
                                        approval_status_update.checked = false
                                        ruc_number_edit.value = data.ruc
                                        r_social_update.value = data.r_social
                                        departamento_update.value = data.departamento
                                        provincia_update.value = data.provincia
                                        distrito_update.value = data.distrito
                                        direccion_update.value = data.address
                                        first_name_update.value = data.first_name
                                        last_name_update.value = data.last_name
                                        email_update.value = data.email
                                        phone_update.value = data.phone
                                        if(data.status == 1){
                                            approval_status_update.checked = true
                                        }
                                    }
                                })
                            })
                        }


                        const  addUSerc =  document.querySelectorAll(".addUSerc")

                        for (let i = 0; i < addUSerc.length; i++) {
                            addUSerc[i].addEventListener('click', function () {
                                idComp.value = addUSerc[i].id
                            })
                        }

                        const type_payment = document.querySelectorAll(".type_payment")
                        for(let i = 0; i < type_payment.length; i++) {
                            type_payment[i].addEventListener("click", function () {

                                $.ajax({
                                    url: "getTypePaymentsForCompany",
                                    data:{id:type_payment[i].id },
                                    type: "GET",
                                    dataType: "JSON",
                                    success: function (data) {
                                        console.log(data)
                                        $("#myPaymets").html(data.myPayments)
                                        $("#noPaymets").html(data.noPayments)
                                    }
                                })
                            })

                        }
                    </script>


@endsection
