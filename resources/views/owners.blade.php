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
                  <th>Nombres</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                   <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>2</td>
                  <td>Cristina Gates</td>
                  <td>cristina@gmail.com</td>
                  <td>945896547</td>
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
                <tr>
                   <td>12</td>
                  <td>Kike</td>
                  <td>kike@gmail.com</td>
                  <td>978569854</td>
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
                <tr>
                  <td>7</td>
                  <td>Mike Torres</td>
                  <td>mike@gmail.com</td>
                  <td>965874547</td>
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
                <tr>
                  <td>12</td>
                  <td>Benito Munya</td>
                  <td>munya@gmail.com</td>
                  <td>948569854</td>
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
               </tbody>

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
             {!! $users->render() !!}
            </div>
          </div>
@endsection
