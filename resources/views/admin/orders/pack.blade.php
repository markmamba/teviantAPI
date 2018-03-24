@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>Pack</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">Pack</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ route('order.show', $crud->model->id) }}"><i class="fa fa-angle-double-left"></i> Back to order</a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		  {!! Form::open(array('url' => $crud->route, 'method' => 'patch', 'files'=>$crud->hasUploadFields('create'))) !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">Pack Order #{{ $crud->model->id }}</h3>
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif
		    </div><!-- /.box-body -->
		    <div class="box-footer">

                @include('admin.orders.form_save_buttons')

		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>

@endsection
