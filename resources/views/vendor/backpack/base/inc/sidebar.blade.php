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
          @if(
            auth()->user()->can('metrics.index') ||
            auth()->user()->can('categories.index') ||
            auth()->user()->can('locations.index') ||
            auth()->user()->can('inventories.index') ||
            auth()->user()->can('stocks.index') ||
            auth()->user()->can('movements.index') ||
            auth()->user()->can('suppliers.index')
          )
          <li class="treeview">
            <a href="#"><i class="fa fa-archive"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              {{-- Metrics --}}
              @if(auth()->user()->can('metrics.index'))
                <li><a href="{{ backpack_url('metric') }}"><i class="fa fa-balance-scale"></i> <span>Metrics</span></a></li>
              @endif
              {{-- Category --}}
              @if(auth()->user()->can('categories.index'))
                <li><a href="{{ backpack_url('category') }}"><i class="fa fa-tags"></i> <span>Categories</span></a></li>
              @endif
              {{-- Locations --}}
              @if(auth()->user()->can('locations.index'))
                <li><a href="{{ backpack_url('location') }}"><i class="fa fa-map-pin"></i> <span>Locations</span></a></li>
              @endif
              {{-- Inventories --}}
              @if(auth()->user()->can('inventories.index'))
                <li><a href="{{ backpack_url('inventory') }}"><i class="fa fa-star"></i> <span>Items</span></a></li>
              @endif
              {{-- Stock --}}
              @if(auth()->user()->can('stocks.index'))
                <li><a href="{{ backpack_url('stock') }}"><i class="fa fa-th"></i> <span>Stocks</span></a></li>
              @endif
              {{-- Movements --}}
              @if(auth()->user()->can('movements.index'))
                <li><a href="{{ backpack_url('movement') }}"><i class="fa fa-exchange"></i> <span>Movements</span></a></li>
              @endif
              {{-- Suppliers --}}
              @if(auth()->user()->can('suppliers.index'))
                <li><a href="{{ backpack_url('supplier') }}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>
              @endif
            </ul>
          </li>
          @endif

          {{-- Users, Roles Permissions --}}
          @if(
            auth()->user()->can('users.index') ||
            auth()->user()->can('roles.index') ||
            auth()->user()->can('permissions.index')
          )
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              @if(auth()->user()->can('users.index'))
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              @endif
              @if(auth()->user()->can('roles.index'))
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              @endif
              @if(auth()->user()->can('permissions.index'))
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
              @endif
            </ul>
          </li>
          @endif

          @if(
            auth()->user()->can('orders.index')
          )
          <li class="header">OUTBOUND</li>
          {{-- Orders --}}
          <li>
            <a href="{{ backpack_url('order') }}">
              <i class="fa fa-shopping-bag"></i> <span>Orders</span>
              @if($orders_incomplete_count)
                <span class="pull-right-container">
                  <span class="label label-warning pull-right">{{ $orders_incomplete_count }}</span>
                </span>
              @endif
            </a>
          </li>
          @endif

          @if(
            auth()->user()->can('purchase_orders.index') ||
            auth()->user()->can('receivings.orders.index')
          )
          <li class="header">INBOUND</li>
          <li>
            <a href="{{ route('crud.purchase-order.index') }}">
              <i class="fa fa-clipboard"></i> <span>Purchase Orders</span>
              @if($purchase_orders_incomplete_count)
                <span class="pull-right-container">
                  <span class="label label-warning pull-right">{{ $purchase_orders_incomplete_count }}</span>
                </span>
              @endif
            </a>
          </li>
          <li>
            <a href="{{ route('crud.receiving.index') }}">
              <i class="fa fa-download"></i> <span>Receivings</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-share"></i> <span>Transfer Orders</span>
            </a>
          </li>
          @endif

          {{-- <li><a href="{{  backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>Files</span></a></li> --}}

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
