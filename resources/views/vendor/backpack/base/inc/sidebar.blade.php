<?php
    $rqController = new \App\Http\Controllers\Admin\RequestController;
    $notify =  $rqController->rememberRequest();
    $countNotify = (count($notify["company"] )+ count($notify["client"]));
    $json_data = json_encode($notify);

    $newClients = $rqController->newClientes();
//        dd($newClients["clients"]);
//?>

@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ 'https://placehold.it/160x160/00a65a/ffffff/&text='.Auth::user()->name[0] }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="{{ url(config('backpack.base.route_prefix').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li ><a   id="notification_id" href="{{ url(config('backpack.base.route_prefix').'/notifications') }}">
                      <i class="fa fa-bell"  style=" position: relative">
           <span
                        style="position: absolute; font-size: 1em; background: tomato;
                          width: 15px; height: 15px; border-radius: 50%;display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px; ">
                        {{$countNotify}}
           </span>

                          </i>
                      <span style="padding-left: 10px;">
                            Notificaciones

                      </span>
                    </a>
          </li>
           <li><a href="{{ url(config('backpack.base.route_prefix').'/maps') }}"><i class="fa fa-map-marker"></i> <span>Mapa</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/request') }}"><i class="fa fa-info-circle"></i> <span>Solicitudes Cliente Persona</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/request-company') }}"><i class="fa fa-info-circle"></i> <span>Solicitudes Cliente Empresa</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix').'/car-types') }}"><i class="fa fa-car"></i> <span>Autos</span></a></li>
             <li><a href="{{ url(config('backpack.base.route_prefix').'/providers') }}"><i class="fa fa-user-plus"></i> <span>Conductores</span></a></li>
             <li><a href="{{ url(config('backpack.base.route_prefix').'/company') }}"><i class="fa fa-user-plus">
                                         <span style="background: tomato;width: 15px; height: 15px; border-radius: 50%;;display: inline-flex; align-items: center; justify-content: center;
font-size: 1em;position: absolute">
                     {{--{{$newClient["clients"]}}--}}
                                             {{$newClients["company"]}}

                     </span>


                     </i> <span style="padding-left: 10px;">Cliente Empresa</span></a></li>
             <li><a href="{{ url(config('backpack.base.route_prefix').'/clients') }}"><i class="fa fa-user-plus">
                     <span style="background: tomato;width: 15px; height: 15px; border-radius: 50%;;display: inline-flex; align-items: center; justify-content: center;
font-size: 1em;position: absolute">
                     {{--{{$newClient["clients"]}}--}}
                         {{$newClients["clients"]}}

                     </span>

                     </i>


                     <span style="padding-left: 10px;">Cliente Persona</span></a></li>
              {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/owners') }}"><i class="fa fa-users"></i> <span>Usuarios</span></a></li>--}}
             
                {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/promo-codes') }}"><i class="fa fa-code"></i> <span>Promociones</span></a></li>--}}
                 <li><a href="{{ url(config('backpack.base.route_prefix').'/payments') }}"><i class="fa fa-money"></i> <span>Ingresos</span></a></li>
                 {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/show_margin') }}"><i class="fa fa-money"></i> <span>Margen de Ganancia</span></a></li>--}}
              <li><a href="{{ url(config('backpack.base.route_prefix').'/Reports') }}"><i class="fa fa-bar-chart"></i> <span>Reportes</span></a></li>
              {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/general-settings') }}"><i class="fa fa-check-circle-o"></i> <span>Configuraciones</span></a></li>--}}

          <!-- Users, Roles Permissions -->
          {{--<li class="treeview">--}}
            {{--<a href="#"><i class="fa fa-group"></i> <span>User Control</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
            {{--<ul class="treeview-menu">--}}
              {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/user') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a></li>--}}
              {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>--}}
              {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/permission') }}"><i class="fa fa-key"></i> <span>Permisos</span></a></li>--}}
            {{--</ul>--}}
          {{--</li>--}}

          {{--<li class="treeview">--}}
              {{--<a href="#"><i class="fa fa-cogs"></i> <span>Advanced</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
              {{--<ul class="treeview-menu">--}}
                {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>--}}
                {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>--}}
                {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>--}}
                {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>--}}
              {{--</ul>--}}
          {{--</li>--}}



          <!-- ======================================= -->
          {{-- <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

@endif
@section("before_scripts")
    <script>



    </script>

   @endsection