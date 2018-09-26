@extends('backpack::layout')
@section('header')

    <section class="content-header">
        <h1>
            Autos<small>Mostrando todos los autos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Datos</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Autos</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCars">Agregar Auto</button>
            </div>
        </div>
        {{--MODAL--}}

        <div class="modal fade" id="addCars" tabindex="-1" role="dialog"
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
                            Agregar Autos
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <form class="form-horizontal" action="{{route('add-cars')}}" method="post">
                            {{@csrf_field() }}
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
                                       for="inputPassword3" >Asisentos</label>
                                <div class="col-sm-10">
                                    <input type="text"  name="seat_capacity" class="form-control"
                                           id="inputPassword3" placeholder="Asientos"/>
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

                    <!-- Modal Footer -->

                </div>
            </div>
        </div>
        {{--FIN MODAL--}}


        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#id</th>
                    <th>Marca</th>
                    <th>Distancia minima</th>
                    <th>Precio minimo</th>
                    <th>Precio por Km</th>
                    <th>Precio por Tiempo</th>
                    <th>Asientos</th>
                    <th>Estado</th>
                    <th style="text-align: center">Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartypes as $cartype)
                    <tr>
                        <td>{{$cartype->id}}</td>
                        <td>{{$cartype->type}}</td>
                        <td>{{$cartype->base_distance}} miles</td>
                        <td>{{$cartype->minimum_fare}}</td>
                        <td>{{$cartype->price_per_mile}}</td>
                        <td>{{$cartype->price_per_time}}</td>
                        <td>{{$cartype->seat_capacity}}</td>
                        <td>                        <?php if ($cartype->visibility_status == 1) {

                                echo "<span class='badge bg-green'>visible</span>";
                            } elseif ($cartype->visibility_status == 0) {
                                echo "<span class='badge bg-red'>No visible</span>";
                            }
                            ?></td>
                        <td style="text-align: center">
                            <button data-toggle="modal" data-target="#showCar" class="btn btn-success btn-edit" id="{{$cartype->id}}"><i class="fa fa-edit"></i> Editar</button>
                            <a href="{{route("delete_cars", [$cartype->id])}}" class="btn btn-danger" ><i class="fa fa-edit"></i> Eliminar</a> </td>
                    </tr>
                @endforeach
                </tbody>

                </tfoot>
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! $cartypes->render()!!}
        </div>
        <div class="box-footer clearfix">
            Total {!! $cartypes->lastPage()  !!} paginas
        </div>
    </div>
    {{--EDITAR MODAL--}}

    <div class="modal fade" id="showCar" tabindex="-1" role="dialog"
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
                        Editar Auto
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form class="form-horizontal" action="edit-car" method="post">
                        {{@csrf_field() }}
                        <input type="hidden"   name="id" class="form-control"
                               id="id_car_edit" />
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="inputEmail3">Tipo</label>
                            <div class="col-sm-10">
                                <input type="text"   name="type" class="form-control"
                                       id="type" placeholder="Tipo"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Distancia Mínima</label>
                            <div class="col-sm-10">
                                <input type="text"  name="base_distance" class="form-control"
                                       id="distanc" placeholder="Distancia mínima"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Precio Mínimo</label>
                            <div class="col-sm-10">
                                <input type="text"  name="minimum_fare" class="form-control"
                                       id="price_min" placeholder="Precio Mínimo"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Precio por Km</label>
                            <div class="col-sm-10">
                                <input type="text"  name="price_per_mile" class="form-control"
                                       id="price_mile" placeholder="Precio por Km"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Precio por Tiempo</label>
                            <div class="col-sm-10">
                                <input type="text"  name="price_per_time" class="form-control"
                                       id="price_time" placeholder="Precio por Tiempo"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Asientos</label>
                            <div class="col-sm-10">
                                <input type="text"  name="seat_capacity" class="form-control"
                                       id="seat" placeholder="Asientos"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3" >Activo</label>
                            <div class="col-sm-10" >
                                <input type="checkbox" style="position:relative;top:  5px;"  class="form-check-input" name="visibility_status"
                                       id="visibility_status" />
                            </div>
                        </div>
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

@endsection
@section('after_scripts')
    <script>
        let btn_edit = document.querySelectorAll('.btn-edit');
        token = "<?php echo csrf_token(); ?>";

        for (let i = 0; i < btn_edit.length; i++) {
            btn_edit[i].addEventListener('click', function (e) {
                e.preventDefault();
                let id_car = {id_c: btn_edit[i].id};
                $.ajax({
                    url: "show_car",
                    data: id_car,
                    method: "POST",
                    dataType: "json",
                    success: function (data) {
                        id_car_edit.value = data.id;
                        type.value = data.type;
                        distanc.value = data.base_distance;
                        price_min.value = data.minimum_fare;
                        price_mile.value = data.price_per_mile;
                        price_time.value = data.price_per_time;
                        seat.value = data.seat_capacity;
                        let status = data.visibility_status
                        if(status == 1) {
                            visibility_status.checked = true
                        }else {
                            visibility_status.checked = false

                        }
                    }
                })
            })
        }
        $('#showCar').on('hidden.bs.modal', function () {
            id_car_edit.value = "";
            type.value = "";
            distanc.value = "";
            price_min.value = "";
            price_mile.value = "";
            price_time.value = "";
            seat.value = "";
            visibility_status.checked = false

        });

    </script>

@endsection
