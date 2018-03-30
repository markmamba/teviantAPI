@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          {{-- Inventory --}}
          <li class="treeview">
            <a href="#"><i class="fa fa-archive"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              {{-- Metrics --}}
              <li><a href="{{ backpack_url('metric') }}"><i class="fa fa-balance-scale"></i> <span>Metrics</span></a></li>
              {{-- Category --}}
              <li><a href="{{ backpack_url('category') }}"><i class="fa fa-tags"></i> <span>Categories</span></a></li>
              {{-- Locations --}}
              <li><a href="{{ backpack_url('location') }}"><i class="fa fa-map-pin"></i> <span>Locations</span></a></li>
              {{-- Inventories --}}
              <li><a href="{{ backpack_url('inventory') }}"><i class="fa fa-star"></i> <span>Items</span></a></li>
              {{-- Stock --}}
              <li><a href="{{ backpack_url('stock') }}"><i class="fa fa-bars"></i> <span>Stocks</span></a></li>
              {{-- Movements --}}
              <li><a href="{{ backpack_url('movement') }}"><i class="fa fa-exchange"></i> <span>Movements</span></a></li>
              {{-- Suppliers --}}
              <li><a href="{{ backpack_url('supplier') }}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>    
            </ul>
          </li>
          
          {{-- Orders --}}
          <li>
            <a href="{{ backpack_url('order') }}">
              <i class="fa fa-list-alt"></i> <span>Orders</span>
              @if($orders_incomplete_count)
                <span class="pull-right-container">
                  <span class="label label-primary pull-right">{{ $orders_incomplete_count }}</span>
                </span>
              @endif
            </a>
          </li>

          {{-- <li><a href="{{  backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>Files</span></a></li> --}}

          {{-- Users, Roles Permissions --}}
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
