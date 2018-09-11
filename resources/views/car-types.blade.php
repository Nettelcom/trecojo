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
        <div class="box-header">
              <!-- <h3 class="box-title">#</h3> -->
              <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
            </div>
             
           
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
                  <th>Opciones</th>
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
                   <td><button class="btn btn-success"><i class="fa fa-edit"></i> Editar</button> </td>
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
@endsection
