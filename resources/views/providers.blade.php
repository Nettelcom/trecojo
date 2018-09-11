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
                <tr>
                  <td>12</td>
                  <td>Vincent Koech</td>
                  <td>vinukoech@gmail.com</td>
                  <td>isuzu</td>
                  <td>+254785698547</td>
                  <td><a href="#">Ver Imagen</a></td>
                  <td><span class="label label-success">Aceptado</span></td>
                   <td> <div class="input-group-btn">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Historia</a></li>
                    <li><a href="#">Editar</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Eliminar</a></li>
                  </ul>
                </div>
                </td>
                </tr>
                @foreach($providers as $provider)
                <tr>
                   <td>{{$provider->id}}</td>
                  <td>{{$provider->first_name }} {{$provider->last_name }}</td>
                  <td>{{$provider->email }}</td>
                   <td>isuzu</td>
                  <td>{{$provider->contacts }}</td>
                  <td><a href="#">View Image</a></td>
                  <td>                    
                        <?php
                        if ($provider->approval_status == 1) {

                            echo "<span class='badge bg-green'>Approved</span>";
                        } elseif ($walk->approval_status == 0) {
                            echo "<span class='badge bg-red'Pending</span>";
                        }
                        ?></td>
                   <td> <div class="input-group-btn">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Opciones
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Historial</a></li>
                    <li><a href="#">Editar</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Eliminar</a></li>
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
@endsection
