@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">Rollback</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ route('crud.movement.index') }}"><i class="fa fa-angle-double-left"></i> Back to Movements</a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		  {!! Form::open(array('url' => $crud->route, 'method' => 'patch', 'files'=>$crud->hasUploadFields('create'))) !!}
		  <div class="box">

		    <div class="box-header with-border">
		      <h3 class="box-title">Are you sure to complete Transfer Order #{{ $crud->model->id }}?</h3>
		    </div>
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif

				<table class="table">
					<caption>
						Please review the following Transfer Order details. Click the "Save and back" button to complete.
					</caption>
					<thead>
						<th>SKU</th>
						<th>Name</th>
						<th>Quantity</th>
						<th>Location</th>
						<th>Aisle-Row-Bin</th>
					</thead>
					<tbody>
						<tr>
							<td>{{ $crud->model->purchase_order_receiving_product->product->inventory->sku_code }}</td>
							<td>{{ $crud->model->purchase_order_receiving_product->product->inventory->name }}</td>
							<td>{{ $crud->model->quantity }}</td>
							<td>{{ $crud->model->location->name }}</td>
							<td>{{ $crud->model->aisleRowBin }}</td>
						</tr>
					</tbody>
				</table>

		    </div><!-- /.box-body -->
		    <div class="box-footer">

                @include('admin.transfer_orders.form_save_buttons')

		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>

@endsection
