@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Usuarios<small>Mostrar todos los usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Usuarios</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Usuarios</div>
                </div>
            </div>
        </div>
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
    <div class="box">
        <div class="box-header" style="display: flex">
              <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
            <div style="margin-left: 10px">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUser">Agregar Usuario</button>
            </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#id</th>
                  <th>Nombres</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                   <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->first_name}}  {{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->contacts}}</td>
                            <td>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones
                                        <span class="fa fa-caret-down"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a data-toggle="modal" data-target="#showUser" class="btn_edit" id="{{$user->id}}">Editar</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{route('delete_user', [$user->id])}}">Eliminar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                     @endforeach
               </tbody>

              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
             {!! $users->render() !!}
            </div>
          </div>
{{--MODAL--}}
{{--MODAL--}}
{{--MODAL--}}
    <div class="modal fade" id="showUser" tabindex="-1" role="dialog"
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
                        Editar Usuario
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="user_update" method="post">
                        {{@csrf_field() }}
                        <input type="hidden"   name="idUser" class="form-control"
                               id="id_user_update" />
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"   name="first_name" class="form-control"
                                       id="first_name_update" placeholder="Nombre"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Apellidos</label>
                            <div class="col-sm-10">
                                <input type="text"  name="last_name" class="form-control"
                                       id="last_name_update" placeholder="Apellidos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Email</label>
                            <div class="col-sm-10">
                                <input type="text"  name="email" class="form-control"
                                       id="email_update" placeholder="Email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Teléfono</label>
                            <div class="col-sm-10">
                                <input type="text"  name="contacts" class="form-control"
                                       id="contacts_update" placeholder="Teléfono"/>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Activo</label>--}}
                            {{--<div class="col-sm-10" >--}}
                                {{--<input type="checkbox" style="position:relative;top:  5px;"  class="form-check-input" name="visibility_status"--}}
                                       {{--id="visibility_status" />--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal" id="close_edit">
                                Cerrar
                            </button>
                            <input type="submit" value="Editar" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- Modal Footer -->

            </div>
        </div>
    </div>
    {{--FIN MODAL--}}









    {{--MODAL--}}
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog"
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
                        Agregar Usuario
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="add_user" method="post">
                        {{@csrf_field() }}
                        {{--<input type="hidden"   name="idUser" class="form-control"--}}
                               {{--id="id_user_update" />--}}
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"   name="first_name" class="form-control"
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
                                   for="inputPassword3" >Email</label>
                            <div class="col-sm-10">
                                <input type="text"  name="email" class="form-control"
                                       id="email" placeholder="Email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Teléfono</label>
                            <div class="col-sm-10">
                                <input type="text"  name="contacts" class="form-control"
                                       id="contacts" placeholder="Teléfono"/>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label"--}}
                        {{--for="inputPassword3" >Activo</label>--}}
                        {{--<div class="col-sm-10" >--}}
                        {{--<input type="checkbox" style="position:relative;top:  5px;"  class="form-check-input" name="visibility_status"--}}
                        {{--id="visibility_status" />--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal" id="close_edit">
                                Cerrar
                            </button>
                            <input type="submit" value="Registrar" class="btn btn-primary">
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
        const btn_edit =  document.querySelectorAll('.btn_edit');
        for(let i = 0; i <  btn_edit.length; i++) {
            btn_edit[i].addEventListener('click',  function () {
                let idUser = btn_edit[i].id
                $.ajax({
                    url: 'show_update_user',
                    data: {idUser: idUser},
                    dataType: 'JSON',
                    method: 'POST',
                    success: function (data) {
                        first_name_update.value = data.first_name
                        last_name_update.value = data.last_name
                        email_update.value = data.email
                        contacts_update.value = data.contacts
                        id_user_update.value = data.id
                    }
                })
            })
        }

        $('#showUser').on('hidden.bs.modal', function () {
            irst_name_update.value = ""
            last_name_update.value = ""
            email_update.value = ""
            contacts_update.value = ""
            id_user_update.value = ""

        });
    </script>

 @endsection
