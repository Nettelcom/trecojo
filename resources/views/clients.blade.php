@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Solicitudes<small>Mostrar todos los clientes</small>
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
                    <div class="box-title">Clientes</div>
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
            <form method="get" action="filter_cars">
                <div class="input-group input-group-sm" style="width: 150px;">

                    <input type="text" class="form-control pull-right" name="txt_search" placeholder="Buscar...">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            <div style="margin-left: 10px">
                <button class="btn btn-primary" data-toggle="modal" id="btn_add_client" data-target="#addClient">Agregar Cliente</button>
            </div>
        </div><div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Nombres</th>
                    {{--<th>Distancia minima</th>--}}
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Direccíon</th>
                    <th>Departamento</th>
                    <th>Provincia</th>
                    <th>Distrito</th>
                    <th style="text-align: center">Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->first_name}}  {{$client->last_name}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->address}}</td>
                        <td>{{$client->departamento}}</td>
                        <td>{{$client->provincia}}</td>
                        <td>{{$client->distrito}}</td>
                        <td>
                        <button title="Actualizar Datos" data-toggle="modal" data-target="#updateClient" class="btn btn-success btn_edit" id="{{$client->id}}"><i class="fa fa-edit"></i> </button>
                        <button title="Cambiar Contraseña" data-toggle="modal" data-target="#updatePwd" class="btn btn-warning btn_pwd_update" id="{{$client->id}}"><i class="fa fa-key"></i></button>
                        <a href="{{route("delete_client", [$client->id])}}" class="btn btn-danger"  title="Eliminar"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
    </div>

        {{--MODAL--}}

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
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="pwd_client" class="form-control"
                                           placeholder="Contraseña"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Confirmar Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="confirm_pwd" class="form-control"
                                           placeholder="Confirmar Contraseña"/>
                                </div>
                            </div>
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
    {{--FIN MODAL--}}





        <div class="modal fade" id="updateClient" tabindex="-1" role="dialog"
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
                            Actualizar Datos
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <form class="form-horizontal" action="{{route('update_client')}}" id="frm_client" method="post">
                            {{@csrf_field() }}
                            <input type="hidden" id="idClient_update" name="idClient">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="inputEmail3">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="first_name" class="form-control"
                                           id="first_name" placeholder="Nombre"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Apellidos</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="last_name" class="form-control"
                                           id="last_name" placeholder="Apellidos"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Teléfono</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="phone" class="form-control"
                                           id="phone" placeholder="Teléfono"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Email</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="email" class="form-control"
                                           id="email" placeholder="Correo Elenctrónico"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Departamento</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="departamento" class="form-control"
                                           id="departamento" placeholder="Departamento"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Provincia</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="provincia" class="form-control"
                                           id="provincia" placeholder="Provincia"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Distrito</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="distrito" class="form-control"
                                           id="distrito" placeholder="Distrito"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="address" class="form-control"
                                           id="address" placeholder="Dirección"/>
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



        <div class="modal fade" id="updatePwd" tabindex="-1" role="dialog"
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
                            Actualizar Contraseña
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <form class="form-horizontal" action="{{route('update_client_pwd')}}" id="frm_client" method="post">
                            {{@csrf_field() }}
                            <input type="hidden" id="idClient_pwd" name="idClient">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="inputEmail3">Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="pwd_client" class="form-control"
                                           id="pwd_client_new" placeholder="Contraseña"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Nueva Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="new_pwd" class="form-control"
                                           id="new_pwd_new" placeholder="Nueva Contraseña"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputPassword3" >Confirme Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="pwd_confirm" class="form-control"
                                           id="pwd_confirm_new" placeholder="Confirme Contraseña"/>
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

@endsection
@section('after_scripts')
    <script>
            const btn_edit = document.querySelectorAll(".btn_edit");
            for(let i = 0; i < btn_edit.length; i++) {
                btn_edit[i].addEventListener('click', function () {
                    let idClient = btn_edit[i].id
                    $.ajax({
                        url: "get_information_client",
                        data: {idClient: idClient},
                        method: "POST",
                        dataType: "JSON",
                        success: function (data) {
                            console.log(data)
                            idClient_update.value =  idClient
                            first_name.value = data.first_name
                            last_name.value = data.last_name
                            phone.value = data.phone
                            email.value = data.email
                            address.value = data.address
                            departamento.value = data.departamento
                            provincia.value = data.provincia
                            distrito.value = data.distrito
                            btn_client.value = "Actualizar"
                        }
                    })
                })
            }

            $('#addClient').on('hidden.bs.modal', function () {
                first_name.value = ""
                last_name.value = ""
                phone.value = ""
                email.value = ""
                address.value =""
                departamento.value = ""
                provincia.value = ""
                distrito.value = ""
                // btn_client.value = "Actualizar"
            });
            const btn_pwd_update = document.querySelectorAll(".btn_pwd_update")
            for(let i = 0; i < btn_pwd_update.length; i++) {
                btn_pwd_update[i].addEventListener('click', function () {
                    idClient_pwd.value = btn_pwd_update[i].id
                })
            }

            $('#updatePwd').on('hidden.bs.modal', function () {
                idClient_pwd.value = ""
                pwd_client_new.value = ""
                new_pwd_new.value = ""
                pwd_confirm_new.value = ""

            });
    </script>
@endsection