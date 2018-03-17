@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span>{{ title_case($crud->entity_name) }} #{{ $order->id }}</span>
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

	<div class="row">
		<div class="col-md-12">
			@include('errors.list')
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">General Details</h3>
				</div>
				<div class="box-body">
					<h5>Order Id</h5>
					{{ $order->id }}
					<h5>Date</h5>
					{{ $order->created_at }}
					<h5>Customer</h5>
					{{ $order->full_user_name }}
					
					{{-- Show order status accordingly --}}
					<h5>Status</h5>
					@if($order->status->name == 'Pending')
						<span class="label label-warning">Pending</span>
					@endif
					@if($order->status->name == 'Processed')
						<span class="label label-primary">Shipped</span>
					@endif
					@if($order->status->name == 'Delivered')
						<span class="label label-info">Delivered</span>
					@endif
					@if($order->status->name == 'Done')
						<span class="label label-success">Complete</span>
					@endif
					@if($order->status->name == 'Cancelled')
						<span class="label label-danger">Cancelled</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Address</h3>
				</div>
				<div class="box-body">
					<h5>Billing</h5>
					<p>
						{{ $order->full_billing_address }}
					</p>
					<h5>Shipping</h5>
					<p>
						{{ $order->full_billing_address }}
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Order</h3>
				</div>
				<div class="box-body">
					<ul>
						@foreach($order->products as $product)
							<li>
							{{ $product->quantity }} x {{ $product->name }}
								<br>
								SKU: {{ ($product->sku) }}
								<span class="pull-right">{{ number_format($product->price) }}</span>
							</li>
						@endforeach
					</ul>	
				</div>
				<div class="box-footer">
					<p>
						Total <span class="pull-right">{{ number_format($order->total) }}</span>
					</p>
					<p>
						{{-- Show the progressive order button accordingly --}}
						@if($order->status->name == 'Pending')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', '']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Processed')) !!}
								{!! Form::submit('Ship Order', ['class' => 'form-control btn btn-primary']) !!}
							{!! Form::close() !!}
						@endif
						@if($order->status->name == 'Processed')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', '']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Delivered')) !!}
								{!! Form::submit('Set as Delivered', ['class' => 'form-control btn btn-primary']) !!}
							{!! Form::close() !!}
						@endif
						@if($order->status->name == 'Delivered')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', '']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Done')) !!}
								{!! Form::submit('Complete Order', ['class' => 'form-control btn btn-primary']) !!}
							{!! Form::close() !!}
						@endif
					</p>
					{{-- Set the cancel button accordingly --}}
					<p>
						@if($order->status->name != 'Done' && $order->status->name != 'Cancelled')
							{!! Form::open(['route' => ['order.cancel', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Cancelled')) !!}
								{!! Form::submit('Cancel Order', ['class' => 'form-control btn btn-default']) !!}
							{!! Form::close() !!}
						@endif
						@if($order->status->name == 'Done' || $order->status->name == 'Cancelled')
							{!! Form::open(['route' => ['order.reopen', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Pending')) !!}
								{!! Form::submit('Re-open Order', ['class' => 'form-control btn btn-default']) !!}
							{!! Form::close() !!}
						@endif
					</p>
				</div>
			</div>
		</div>
	</div>

	{{-- Picked List (Reservations) panel --}}
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Pick List (Reservations)</h3>
					<br>
					@if($order->isSufficient())
						<span class="label label-success">Sufficient</span>
					@else
						<span class="label label-danger">{{ $order->deficiency }} {{ str_plural('Deficieny', $order->deficiency) }} </span>
					@endif
				</div>
				<div class="box-body">
					<table class="table table-responsive">
						<thead>
							<th>SKU</th>
							<th>Location</th>
							<th>Aisle-Row-Bin</th>
							<th>Reserved</th>
							<th>Picked</th>
							<th>Deficiency</th>
						</thead>
						<tbody>
							@foreach($order->reservations as $reservation)
								<tr>
									<td>{{ $reservation->stock->item->sku_code }}</td>
									<td>{{ $reservation->stock->location->name }}</td>
									<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
									<td>{{ $reservation->quantity_reserved }}</td>
									<td>{{ $reservation->quantity_taken }}</td>
									<td>
										@if(!$reservation->deficiency)
											{{ $reservation->deficiency }}
										@else
											<span class="label label-danger">{{ $reservation->deficiency }}</span>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<a href="{{ route('crud.order.index') }}">
		<i class="fa fa-angle-double-left"></i> Back to all orders
	</a>

@endsection


@section('after_styles')
	{{--  --}}
@endsection

@section('after_scripts')
	{{--  --}}
@endsection