@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Promo<small>Mostrando todos los códigos-promocionales</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Promo-Codes</li>
        
      </ol>

    </section>
@endsection


@section('content')
                <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Códigos promocionales</div>
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
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th> #id</th>
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Estado</th>
                  <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>Vincent Koech</td>
                  <td>214785gbfr</td>
                  
                  <td><span class="label label-success">realizado</span></td>
                  <td>1/1/15</td>
                  <td><span class="label label-success">Eliminar</span></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Bob Marley</td>
                  <td>ht214785gbfr</td>
                  
                  <td><span class="label label-danger">Pendiente</span></td>
                  <td>1/1/15</td>
                  <td><span class="label label-success">Eliminar</span></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Siva Mamilla</td>
                  <td>rews34huy</td>
                  
                  <td><span class="label label-danger">no realizado</span></td>
                  <td>1/1/15</td>
                  <td><span class="label label-success">Eliminar</span></td>
                </tr>
               
               </tbody>

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
           
          </div>
@endsection
