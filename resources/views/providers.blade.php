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
                                                   for="inputPassword3" >Imagen</label>
                                            <div class="col-sm-10">
                                                <input type="file"  name="picture" class="form-control"
                                                       id="inputPassword3" placeholder="Asientos"/>
                                            </div>
                                        </div>

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
                                            <input type="text"  name="type" class="form-control"
                                                   id="inputEmail3" placeholder="Tipo"/>
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
                                               for="inputPassword3" >Distancia Mínima</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="base_distance" class="form-control"
                                                   id="inputPassword3" placeholder="Distancia mínima"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Precio Mínimo</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="minimum_fare" class="form-control"
                                                   id="inputPassword3" placeholder="Precio Mínimo"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Precio por Km</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="price_per_mile" class="form-control"
                                                   id="inputPassword3" placeholder="Precio por Km"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="inputPassword3" >Precio por Tiempo</label>
                                        <div class="col-sm-10">
                                            <input type="text"  name="price_per_time" class="form-control"
                                                   id="inputPassword3" placeholder="Precio por Tiempo"/>
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
                  <th>Marca</th>
                  <th>Teléfono</th>
                  <th>Foto</th>
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
                   <td>{{$provider->cartype["type"]}}</td>
                  <td>{{$provider->contacts }}</td>
                  <td><a class="imgProvider" id="{{$provider->id}}" data-toggle="modal" data-target="#popUpImg">Ver Imagen</a></td>
                  <td>                    
                        <?php
                        if ($provider->approval_status == 1):
                            ?>
                             <a href='{{route("chage_status_provider",[$provider->id])}}' class='btn btn-success'>Aprovado</a>
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
                    <li><a href="#">Historial</a></li>
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



    <!-- Modal -->
    <div class="modal fade" id="showProvider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Conductor</h4>

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
                                                   for="inputPassword3" >Imagen</label>
                                            <div class="col-sm-10">
                                                <input type="file"  name="picture" class="form-control"
                                                       id="picture" placeholder="Asientos"/>
                                            </div>
                                        </div>

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
                                                <input type="text"  name="type" class="form-control"
                                                       id="type" placeholder="Tipo"/>
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
                                                   for="inputPassword3" >Distancia Mínima</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="base_distance" class="form-control"
                                                       id="base_distance" placeholder="Distancia mínima"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Precio Mínimo</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="minimum_fare" class="form-control"
                                                       id="minimum_fare" placeholder="Precio Mínimo"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Precio por Km</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="price_per_mile" class="form-control"
                                                       id="price_per_mile" placeholder="Precio por Km"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="inputPassword3" >Precio por Tiempo</label>
                                            <div class="col-sm-10">
                                                <input type="text"  name="price_per_time" class="form-control"
                                                       id="price_per_time" placeholder="Precio por Tiempo"/>
                                            </div>
                                        </div>
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




    <div class="modal fade" id="popUpImg" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body center" style="display: flex; justify-content: center; align-items: center">
                    <img id="img_popup"  class="img-responsive" style="display: block; width: 500px; height: 300px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

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
                        idProvider.value = data[0].id
                        first_name.value = data[0].first_name
                        last_name.value = data[0].last_name
                        contacts.value = data[0].contacts
                        email.value = data[0].email
                        // picture.value = data[0].picture


                        type.value = data[1][0].type
                        base_distance.value = data[1][0].base_distance
                        placa.value = data[1][0].placa
                        minimum_fare.value = data[1][0].minimum_fare
                        price_per_mile.value = data[1][0].price_per_mile
                        price_per_time.value = data[1][0].price_per_time
                        seat_capacity.value = data[1][0].seat_capacity
                    }
                })
            })
        }
    </script>

@endsection

