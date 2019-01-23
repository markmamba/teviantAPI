@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">Order #{{ $order->common_id }}</span>
        <small>Product Reservations</small>
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
		@include('errors.list')
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ route('order.show', $order->id) }}"><i class="fa fa-angle-double-left"></i> Back to order</a><br><br>
		@endif

		<div class="box box-default">
			<div class="box-header">
				<h3 class="box-title">Ship Package</h3>
			</div>
			<div class="box-body">

				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">Order #</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">{{ $order->common_id }}</p>
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Sales Invoice #</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">{{ $order->packages->first()->sales_invoice_number }}</p>
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Carrier</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">LBC</p>
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tracking #</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static">{{ $order->packages->first()->tracking_number }}</p>
					    </div>
					</div>
				</div>
				
				{!! Form::open(['url' => route('order.reservations.post_ship', $order->id), 'method' => 'POST', 'id' => 'orderShippingForm']) !!}
				{!! Form::hidden('order_id', $order->id) !!}
				{!! Form::hidden('carrier', 'LBC') !!}

				<table class="table table-hover table-bordered">
					<caption>Products</caption>
					<thead>
						<th>SKU</th>
						<th>Name</th>
						<th>Quantity</th>
						<th>Date Packed</th>
					</thead>
					<tbody>
						@foreach($order->reservations->groupBy('order_product_id') as $key => $item)
							@foreach($item as $reservation)
								<tr>
									<td>{{ $reservation->stock->item->sku_code }}</td>
									<td>{{ $reservation->stock->item->name }}</td>
									<td>{{ $reservation->order_product->quantity_reserved }}</td>
									<td>{{ $reservation->packed_at }}</td>
								</tr>
							@endforeach
						@endforeach
					</tbody>
				</table>
				{!! Form::close() !!}
			</div>
			<div class="box-footer text-right">
				<button type="submit" form="orderShippingForm" class="btn btn-primary btn-flat" onclick="return confirm('Click OK to proceed.');">Confirm Shipment</button>
			</div>
		</div>

		@include('crud::inc.grouped_errors')
	</div>
</div>

@endsection
