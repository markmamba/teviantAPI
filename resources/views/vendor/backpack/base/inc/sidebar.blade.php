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
        
          {{-- Metrics --}}
          <li><a href="{{ backpack_url('metric') }}"><i class="fa fa-balance-scale"></i> <span>Metrics</span></a></li>
          {{-- Category --}}
          <li><a href="{{ backpack_url('category') }}"><i class="fa fa-tags"></i> <span>Categories</span></a></li>
          {{-- Inventories --}}
          <li><a href="{{ backpack_url('inventory') }}"><i class="fa fa-archive"></i> <span>Inventories</span></a></li>
          {{-- Locations --}}
          <li><a href="{{ backpack_url('location') }}"><i class="fa fa-map-pin"></i> <span>Locations</span></a></li>
          {{-- Suppliers --}}
          <li><a href="{{ backpack_url('supplier') }}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>

          <li><a href="{{  backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>Files</span></a></li>

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
