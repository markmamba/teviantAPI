@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span>Ship Order #{{ $order->id }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
	{{--  --}}

	{{-- Picked List (Reservations) panel --}}
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include('errors.list')

			{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', '']) !!}
			{!! Form::hidden('status_id', $order_status_options->search('Shipped')) !!}
			<div class="box">
				<div class="box-header with-border">
					<h3 class="panel-title">Shipment Form</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Carrier</label>
						<p class="form-control-static">
							{{ $order->carrier->name }}
						</p>
					</div>
					<div class="form-group">
						<label>Delivery Text</label>
						<p class="form-control-static">
							{{ $order->carrier->delivery_text }}
						</p>
					</div>
				</div>
				<div class="box-footer">
					<div class="form-group">
						<a href="{{ route('order.print_receipt', $order->id) }}" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Official Receipt</a>
						<a href="#" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Delivery Receipt</a>
						<a href="#" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Carrier Receipt</a>
						<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Confirm Shipment</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>

	<a href="{{ route('order.show', $order) }}">
		<i class="fa fa-angle-double-left"></i> Back to order
	</a>

@endsection


@section('after_styles')
	{{--  --}}
@endsection

@section('after_scripts')
	{{--  --}}
@endsection