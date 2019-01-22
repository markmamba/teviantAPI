@extends('backpack::layout')

@section('header')
  <section class="content-header">
    <h1>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? trans('backpack::crud.all').'<span>'.$crud->entity_name_plural.'</span> '.trans('backpack::crud.in_the_database') !!}.</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
      <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
      <li class="active">{{ trans('backpack::crud.list') }}</li>
    </ol>
  </section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
      <div class="box">
        <div class="box-header {{ $crud->hasAccess('create')?'with-border':'' }}">

          <div class="pull-right">
            @include('crud::inc.button_stack', ['stack' => 'top'])
          </div>
          
          <ul class="nav nav-tabs">
            <li class="{{ !isset($tab) ? 'active' : null }}">
              <a href="{{ route('crud.order.index') }}">All</a>
            </li>
            <li class="{{ isset($tab) && $tab == 'pending' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'pending']) }}">Pending <span class="label {{ $orders_on_statuses_count['pending'] > 0 ? 'label-warning' : 'label-default' }}">{{ $orders_on_statuses_count['pending'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'partial' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'partial']) }}">Partial <span class="label {{ $orders_on_statuses_count['partial'] > 0 ? 'label-info' : 'label-default' }}">{{ $orders_on_statuses_count['partial'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'for_picking' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'for_picking']) }}">For Picking <span class="label label {{ $orders_on_statuses_count['for_picking'] > 0 ? 'label-warning' : 'label-default' }}">{{ $orders_on_statuses_count['for_picking'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'for_shipping' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'for_shipping']) }}">For Shipping <span class="label {{ $orders_on_statuses_count['for_shipping'] > 0 ? 'label-warning' : 'label-default' }}">{{ $orders_on_statuses_count['for_shipping'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'shipped' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'shipped']) }}">Shipping <span class="label {{ $orders_on_statuses_count['shipped'] > 0 ? 'label-primary' : 'label-default' }}">{{ $orders_on_statuses_count['shipped'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'completed' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'completed']) }}">Completed <span class="label {{ $orders_on_statuses_count['completed'] > 0 ? 'label-success' : 'label-default' }}">{{ $orders_on_statuses_count['completed'] }}</span></a>
            </li>
            <li class="{{ isset($tab) && $tab == 'cancelled' ? 'active' : null }}">
              <a href="{{ route('crud.order.index', ['tab' => 'cancelled']) }}">Cancelled <span class="label {{ $orders_on_statuses_count['cancelled'] > 0 ? 'label-danger' : 'label-default' }}">{{ $orders_on_statuses_count['cancelled'] }}</span></a>
            </li>
          </ul>

          <div id="datatable_button_stack" class="pull-right text-right"></div>

        </div>

        <div class="box-body table-responsive">

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        <table id="crudTable" class="table table-striped table-hover display">
            <thead>
              <tr>
                @if ($crud->details_row)
                  <th data-orderable="false"></th> <!-- expand/minimize button column -->
                @endif

                {{-- Table columns --}}
                @foreach ($crud->columns as $column)
                  <th {{ isset($column['orderable']) ? 'data-orderable=' .var_export($column['orderable'], true) : '' }}>
                    {{ $column['label'] }}
                  </th>
                @endforeach

                @if ( $crud->buttons->where('stack', 'line')->count() )
                  <th data-orderable="false">{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                @if ($crud->details_row)
                  <th></th> <!-- expand/minimize button column -->
                @endif

                {{-- Table columns --}}
                @foreach ($crud->columns as $column)
                  <th>{{ $column['label'] }}</th>
                @endforeach

                @if ( $crud->buttons->where('stack', 'line')->count() )
                  <th>{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </tfoot>
          </table>

        </div><!-- /.box-body -->

        @include('crud::inc.button_stack', ['stack' => 'bottom'])

      </div><!-- /.box -->
    </div>

  </div>

@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')

  <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
