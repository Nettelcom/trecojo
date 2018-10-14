    @extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Conductores<small>Mostrar todo los conductores</small>
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
                    <div class="box-title">Conductores</div>
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addProvider">Agregar Conductor</button>
            </div>
            </div>
        <!-- Modal -->
        <div class="modal fade" id="addProvider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                        </button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Conductor</h4>

                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">

                        <form class="form-horizontal" action="{{route('add-driver')}}" method="post" enctype="multipart/form-data">
                        {{@csrf_field() }}
                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#uploadTab" aria-controls="uploadTab" role="tab" data-toggle="tab">Conductor</a>

                                </li>
                                <li role="presentation"><a href="#browseTab" aria-controls="browseTab" role="tab" data-toggle="tab">Auto</a>

                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="uploadTab">
                                    {{--MODAL CONDUCTOR--}}
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                    for="inputEmail3">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="first_name" class="form-control"
                                                       id="inputEmail3" placeholder="Nombres"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Apellidos</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="last_name" class="form-control"
                                                       id="inputPassword3" placeholder="Apellidos"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Email</label>
                                            <div class="col-sm-10">
                                                <input type="text"  required name="email" class="form-control"
                                                       id="inputPassword3" placeholder="Correo Electrónico"/>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Celular</label>
                                            <div class="col-sm-10">
                                                <input type="text"   name="contacts" class="form-control"
                                                       id="inputPassword3" placeholder="Número de Celular"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Número de Cuenta</label>
                                            <div class="col-sm-10">
                                                <input type="number"   name="number_acount" class="form-control"
                                                     placeholder="Número de Cuenta"/>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label"--}}
                                                   {{--for="inputPassword3" >Imagen</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="file"  name="picture" class="form-control"--}}
                                                       {{--id="inputPassword3" placeholder="Asientos"/>--}}
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


                            </div>
                            <div role="tabpanel" class="tab-pane" id="browseTab">
                                {{--MODAL AUTO--}}

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label"
                                                for="inputEmail3">Tipo</label>
                                        <div class="col-sm-10">
                                            <select name="type" id="" class="form-control">
                                                <option value="">Seleccione un Vehículo</option>
                                                @foreach($type_car as $t_car)

                                                    <option value="{{$t_car->id}}">{{$t_car->type_c}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Placa de Vehículo</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="placa" class="form-control"
                                                   id="inputPassword3" placeholder="Place de Vehículo"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Modelo</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="modelo" class="form-control"
                                                   id="inputPassword3" placeholder="Modelo"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Color</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="color" class="form-control"
                                                   id="inputPassword3" placeholder="Color"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Año</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="anio" class="form-control"
                                                   id="inputPassword3" placeholder="Año"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Asientos</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="seat_capacity" class="form-control"
                                                   id="inputPassword3" placeholder="Asientos"/>
                                        </div>
                                    </div>
                                </div>
                                {{--FIN MODAL AUTO--}}
                        </div>
                    </div>


                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <input type="submit" value="Registrar" class="btn btn-primary save">
                    </div>
                    </form>
                </div>
                </div></div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#id</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Vehículo</th>
                  <th>Teléfono</th>
                  <th>Número de Cuenta</th>
                  <th>Estado</th>
                   <th>Opciones</th>
                </tr>
                </thead>
                <tbody>

                @foreach($providers as $provider)
                <tr>
                   <td>{{$provider->id}}</td>
                  <td>{{$provider->first_name }} {{$provider->last_name }}</td>
                  <td>{{$provider->email }}</td>
                   <td>
                       @foreach($type_car as $t_car)
                           @if($provider->cartype[0]->type == $t_car->id)
                               {{$t_car->type_c}}
                           @endif

                       @endforeach
                       </td>
                  <td>{{$provider->contacts }}</td>
{{--                  <td><a class="imgProvider" id="{{$provider->id}}" data-toggle="modal" data-target="#popUpImg">Ver Imagen</a></td>--}}
                    <td>{{$provider->number_acount}}</td>
                  <td>
                        <?php
                        if ($provider->approval_status == 1):
                            ?>
                             <a href='{{route("chage_status_provider",[$provider->id])}}' class='btn btn-success'>Aprobado</a>
                         <?php
                        elseif ($provider->approval_status == 0) :
                            ?>
                             <a  href='{{route("chage_status_provider",[$provider->id])}}'  class="btn btn-danger btn-sm">Pendiente</a>
                         <?php
                        endif
                        ?></td>
                   <td> <div class="input-group-btn">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    {{--<li><a data-target="#addCars" id="{{$provider->id}}" class="addCarsBtn" data-toggle="modal">Agregar Vehículo</a></li>--}}
                    <li><a  class="btn_edit" data-toggle="modal" id="{{$provider->id}}" data-target="#showProvider" href="">Editar</a></li>
                    <li class="divider"></li>
                    <li><a href="{{route('delete_provider', [$provider->id])}}">Eliminar</a></li>
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
             {!! $providers->render() !!}
            </div>
          </div>
{{--{{dd($type_car)}}--}}


    <!-- Modal -->
    <div class="modal fade" id="showProvider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Conductor</h4>

                </div>
                <div class="modal-body">
                    <div role="tabpanel">

                        <form class="form-horizontal" action="{{route('edit-driver')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idProvider" id="idProvider">
                        {{@csrf_field() }}
                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#Conductor" aria-controls="uploadTab" role="tab" data-toggle="tab">Conductor</a>

                                </li>
                                <li role="presentation"><a href="#Auto" aria-controls="browseTab" role="tab" data-toggle="tab">Auto</a>

                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Conductor">
                                    {{--MODAL CONDUCTOR--}}
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label   class="col-sm-2 control-label"
                                                     for="inputEmail3">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" required name="first_name" class="form-control"
                                                       id="first_name" placeholder="Nombres"/>
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


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Celular</label>
                                            <div class="col-sm-10">
                                                <input type="text"   name="contacts" class="form-control"
                                                       id="contacts" placeholder="Número de Celular"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Número de Cuenta</label>
                                            <div class="col-sm-10">
                                                <input type="number"   name="number_acount" class="form-control"
                                                       id="acount" placeholder="Número de Cuenta"/>
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


                                </div>
                                <div role="tabpanel" class="tab-pane" id="Auto">
                                    {{--MODAL AUTO--}}

                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label"
                                                    for="inputEmail3">Tipo</label>
                                            <div class="col-sm-10">
                                                {{--<input type="text"  name="type" class="form-control"--}}
                                                       {{--id="type" placeholder="Tipo"/>--}}
                                                <select name="type" id="" class="form-control">
                                                    <option value="">Seleccione un Vehículo</option>
                                                    @foreach($type_car as $t_car)

                                                        <option class="type_car" value="{{$t_car->id}}">{{$t_car->type_c}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Placa de Vehículo</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="placa" class="form-control"
                                                       id="placa" placeholder="Place de Vehículo"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Modelo</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="modelo" class="form-control"
                                                       id="modelo" placeholder="Modelo"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Color</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="color" class="form-control"
                                                       id="color" placeholder="Color"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Año</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="anio" class="form-control"
                                                       id="anio" placeholder="Año"/>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Asientos</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="seat_capacity" class="form-control"
                                                       id="seat_capacity" placeholder="Asientos"/>
                                            </div>
                                        </div>
                                    </div>
                                    {{--FIN MODAL AUTO--}}
                                </div>
                            </div>


                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Actualizar" class="btn btn-primary save">
                </div>
                </form>
            </div>
        </div></div>
    {{--FIN MODAL--}}




    {{--<div class="modal fade" id="popUpImg" role="dialog">--}}
        {{--<div class="modal-dialog">--}}

            {{--<!-- Modal content-->--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-body center" style="display: flex; justify-content: center; align-items: center">--}}
                    {{--<img id="img_popup"  class="img-responsive" style="display: block; width: 500px; height: 300px;">--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="modal fade" id="addCars" tabindex="-1" role="dialog"--}}
         {{--aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<!-- Modal Header -->--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close"--}}
                            {{--data-dismiss="modal">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                        {{--<span class="sr-only">Close</span>--}}
                    {{--</button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">--}}
                        {{--Agregar Autos--}}
                    {{--</h4>--}}
                {{--</div>--}}

                {{--<!-- Modal Body -->--}}
                {{--<div class="modal-body">--}}

                    {{--<form class="form-horizontal" action="{{route('add_car_provider')}}" method="post">--}}
                        {{--<input type="hidden" id="idProviderEdit" name="idProviderEdit">--}}
                        {{--{{@csrf_field() }}--}}
                        {{--<div class="form-group">--}}
                            {{--<label  class="col-sm-2 control-label"--}}
                                    {{--for="inputEmail3">Tipo</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="type" class="form-control"--}}
                                       {{--id="inputEmail3" placeholder="Tipo"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Modelo</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="modelo" class="form-control"--}}
                                       {{--id="placa" placeholder="Place de Vehículo"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Número de Placassss</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="placa" class="form-control"--}}
                                       {{--id="inputPassword3" placeholder="Número de Placa"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Color</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="color" class="form-control"--}}
                                       {{--id="inputPassword3" placeholder="Color"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Año</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="anio" class="form-control"--}}
                                       {{--id="inputPassword3" placeholder="Año"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label"--}}
                                   {{--for="inputPassword3" >Asientos</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<input type="text"  name="seat_capacity" class="form-control"--}}
                                       {{--id="inputPassword3" placeholder="Asientos"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="modal-footer">--}}
                            {{--<button type="button" class="btn btn-default"--}}
                                    {{--data-dismiss="modal">--}}
                                {{--Cerrar--}}
                            {{--</button>--}}
                            {{--<input type="submit" value="Registrar" class="btn btn-primary">--}}
                        {{--</div>--}}
                    {{--</form>--}}

                {{--</div>--}}

                {{--<!-- Modal Footer -->--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--FIN MODAL--}}




@endsection
@section('after_scripts')

    <script>
        const imgProvider = document.querySelectorAll(".imgProvider")
        for (let  i = 0; i < imgProvider.length; i++) {
            imgProvider[i].addEventListener('click', function (e) {
                    e.preventDefault()
                    idProvider = imgProvider[i].id
                    token = "<?php echo csrf_token(); ?>";
                $.ajax({
                    url: "show_img",
                    data: {idDriver: idProvider, _token: token},
                    dataType: "json",
                    method: "POST",
                    success: function (data) {
                        // console.log(data)
                        const img = data.split("/");
                        // console.log(img)
                        img_popup.src = `/storage/${img[1]}`
                    }
                })
            })
        }
        $('#popUpImg').on('hidden.bs.modal', function () {
            img_popup.src = ""
        });

        const btn_edit =  document.querySelectorAll(".btn_edit")
        for(let i = 0; i < btn_edit.length; i++) {
            btn_edit[i].addEventListener('click', function () {
                let id_provider = btn_edit[i].id
                $.ajax({
                    url: "show_provider",
                    data: {idProvider: id_provider},
                    dataType: "JSON",
                    method: "POST",
                    success: function (data) {
                        // console.log(data)
                        idProvider.value = data[0].id
                        first_name.value = data[0].first_name
                        last_name.value = data[0].last_name
                        contacts.value = data[0].contacts
                        email.value = data[0].email
                        acount.value = data[0].number_acount
                        // picture.value = data[0].picture

                        let type_car = document.querySelectorAll(".type_car")
                        // console.log(type_car[2].value)
                        for(let i = 0; i < type_car.length; i++) {
                            if(type_car[i].value == data[1][0].type ) {
                                type_car[i].selected = true
                            }
                        }
                        // type.value = data[1][0].type
                        // base_distance.value = data[1][0].base_distance
                        placa.value = data[1][0].placa
                        modelo.value = data[1][0].modelo
                        color.value = data[1][0].color
                        anio.value = data[1][0].anio
                        seat_capacity.value = data[1][0].seat_capacity
                    }
                })
            })
        }

        const addCarsBtn = document.querySelectorAll('.addCarsBtn')
        for(let i = 0; i < addCarsBtn.length; i++) {
            addCarsBtn[i].addEventListener('click', function () {
                idProviderEdit.value = addCarsBtn[i].id
            })
        }
        // ruc_number.addEventListener('blur', function () {
        //
        //      $.ajax({
        //          url: 'consult_ruc',
        //         data: { ruc_value : ruc_number.value },
        //          dataType: 'JSON',
        //          method: 'GET',
        //          headers: {
        //              'Content-Type': 'application/json'
        //          },
        //          success: function (data) {
        //
        //            if( data.success === false) {
        //                response_ruc.textContent =  data.error
        //                r_social.value = ""
        //                departamento.value = ""
        //                provincia.value = ""
        //                distrito.value = ""
        //                direccion.value = ""
        //                estado.value = ""
        //                acount.value = ""
        //            }
        //            if(data.success === true) {
        //                 r_social.value = data.nombre_o_razon_social
        //                departamento.value = data.departamento
        //                provincia.value = data.provincia
        //                distrito.value = data.distrito
        //                direccion.value = data.direccion_completa
        //                estado.value = data.estado_del_contribuyente
        //                response_ruc.textContent =  ""
        //            }
        //          }
        //
        //      })
        // })
    </script>

@endsection

