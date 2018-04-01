@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span>
	    	{{ title_case($crud->entity_name) }} #{{ $order->id }}
	    </span>
	    <small>
	    	@if($order->status->name == 'Pending')
				<span class="label label-warning">Pending</span>
			@endif
			@if($order->status->name == 'Pick Listed')
				<span class="label label-primary">Ready for Picking</span>
			@endif
			@if($order->status->name == 'Packed')
				<span class="label label-primary">Ready for Shipping</span>
			@endif
			@if($order->status->name == 'Shipped')
				<span class="label label-primary">Shipping</span>
			@endif
			@if($order->status->name == 'Delivered')
				<span class="label label-primary">Delivered</span>
			@endif
			@if($order->status->name == 'Done')
				<span class="label label-success">Done</span>
			@endif
			@if($order->status->name == 'Cancelled')
				<span class="label label-danger">Cancelled</span>
			@endif
	    </small>
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
					<span class="label label-default">{{ $order->status->name }}</span>
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
						{{-- 
							Show the appropriate primary button according to the order's current status
							- Pending
							- Pick Listed
							- Packed
							- Shipped
							- Delivered
							- Cancelled
						 --}}
						@if($order->status->name == 'Pending')
							@if($order->isSufficient())
								{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH']) !!}
									{!! Form::hidden('status_id', $order_status_options->search('Pick Listed')) !!}
									{!! Form::submit('Set as Pick-listed', ['class' => 'form-control btn btn-primary']) !!}
								{!! Form::close() !!}
							@else
								<a href="#" class="btn btn-primary btn-block" disabled>Set as Pick-listed</a>
							@endif
						@endif
						@if($order->status->name == 'Pick Listed')
							<a href="{{ route('order.pack', $order->id) }}" class="btn btn-primary btn-block">Pack Order</a>
						@endif
						@if($order->status->name == 'Packed')
							<a href="{{ route('order.ship', $order->id) }}" class="btn btn-primary btn-block">Ship Order</a>
						@endif
						@if($order->status->name == 'Shipped')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Delivered')) !!}
								{!! Form::submit('Set as Delivered', ['class' => 'form-control btn btn-primary']) !!}
							{!! Form::close() !!}
						@endif
						@if($order->status->name == 'Delivered')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Done')) !!}
								{!! Form::submit('Set as Done', ['class' => 'form-control btn btn-primary']) !!}
							{!! Form::close() !!}
						@endif
					</p>
					{{-- Set the cancel button accordingly --}}
					<p>
						{{-- Cancel button --}}
						@if($order->status->name != 'Done' && $order->status->name != 'Cancelled')
							{!! Form::open(['route' => ['order.cancel', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Cancelled')) !!}
								{!! Form::submit('Cancel Order', ['class' => 'form-control btn btn-default']) !!}
							{!! Form::close() !!}
						@endif
						{{-- Reopen button --}}
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
					<div class="row">
						<div class="col-md-3">
							<h3 class="box-title">Pick List</h3>
							<br>
							@if($order->isSufficient())
								<p class="text-success">Ready for pick-up.</p>
							@else
								<p class="text-warning">Insufficient stocks. Replenish stocks!</p>
							@endif
						</div>
						<div class="col-md-9">
							<div class="pull-right">
								@if($order->isSufficient())
									<a href="{{ route('order.print_pick_list', $order->id) }}" class="btn btn-default btn-sm" title="Print Pick List" data-toggle="tooltip" target="_blank"><i class="fa fa-print"></i> Pick List</a>
									<a href="{{ route('order.print_receipt', $order->id) }}" class="btn btn-default btn-sm" title="Print Official Receipt" data-toggle="tooltip" target="_blank"><i class="fa fa-print"></i> Official Receipt</a>
									<a href="{{ route('order.print_delivery_receipt', $order->id) }}" class="btn btn-default btn-sm" title="Print Delivery Receipt" data-toggle="tooltip" target="_blank"><i class="fa fa-print"></i> Delivery Receipt</a>
									<a href="{{ route('order.print_carrier_receipt', $order->id) }}" class="btn btn-default btn-sm" title="Print Carrier Receipt" data-toggle="tooltip" target="_blank"><i class="fa fa-print"></i> Carrier Receipt</a>
									<a href="{{ route('order.print_all', $order->id) }}" class="btn btn-default btn-sm" title="Print All" data-toggle="tooltip" target="_blank"><i class="fa fa-print"></i> Print All</a>
								@else
									<a href="#" class="btn btn-default btn-sm" title="Pick List" data-toggle="tooltip" disabled><i class="fa fa-print"></i> Pick List</a>
									<a href="#" class="btn btn-default btn-sm" title="Print Official Receipt" data-toggle="tooltip" disabled><i class="fa fa-print"></i> Official Receipt</a>
									<a href="#" class="btn btn-default btn-sm" title="Print Delivery Receipt" data-toggle="tooltip" disabled><i class="fa fa-print"></i> Delivery Receipt</a>
									<a href="#" class="btn btn-default btn-sm" title="Print Carrier Receipt" data-toggle="tooltip" disabled><i class="fa fa-print"></i> Carrier Receipt</a>
									<a href="#" class="btn btn-default btn-sm" title="Print All" data-toggle="tooltip" disabled><i class="fa fa-print"></i> Print All</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-responsive">
						<thead>
							<th>SKU</th>
							<th>Quantity</th>
							<th>Location</th>
							<th>Aisle-Row-Bin</th>
							<th>Reserved</th>
							<th>Picked</th>
							<th>Picker</th>
							<th>Date Picked</th>
						</thead>
						@foreach($order->reservations->groupBy('order_product_id') as $key => $item)
							<tbody>
							@foreach($item as $reservation)
								<tr>
									<td>{{ $reservation->stock->item->sku_code }}</td>
									<td>{{ $reservation->order_product->quantity }}</td>
									<td>{{ $reservation->stock->location->name }}</td>
									<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
									<td>{{ $reservation->quantity_reserved }}/{{ $reservation->order_product->quantity }}</td>
									<td>{{ $reservation->total_picked }}/{{ $reservation->order_product->quantity }}</td>
									<td>{{ $reservation->pickings->first()->picker->name or null }}</td>
									<td>{{ $reservation->picked_at or null }}</td>
								</tr>
							@endforeach
								<tr>
									<td class="text-right" colspan="8">
										<strong>Total ordered:</strong> {{ $reservation->order_product->quantity }}
										<br>
										<strong>Total reserved:</strong> {{ $reservation->order_product->reservations->sum('quantity_reserved') }}
										<br>
										<strong>Total deficiency:</strong> 
										@if($reservation->order_product->isFullyReserved())
											<span class="label label-success">
												{{ $reservation->order_product->quantity - $reservation->order_product->reservations->sum('quantity_reserved')}}
											</span>
										@else
											<span class="label label-danger">{{ $reservation->order_product->quantity - $reservation->order_product->reservations->sum('quantity_reserved')}}</span>
										@endif
									</td>
								</tr>
								</tr>
							</tbody>
						@endforeach
					</table>
				</div>
				<div class="box-footer">
					@if(in_array($order->status->name, ['Packed', 'Shipped', 'Delivered', 'Done']))
						Packed by {{ $order->packer->name }} on {{ $order->packed_at }}
					@endif
				</div>
			</div>
		</div>
	</div>

	{{-- Shipment Panel --}}
	@if(in_array($order->status->name, ['Shipped', 'Delivered', 'Done']))
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Shipment</h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label>Carrier</label>
				<p class="form-control-static">{{ $order->carrier->name }}</p>
			</div>
			<div class="form-group">
				<label>Package Dimensions</label>
				@if(isset($order->shipment->package_length, $order->shipment->package_width, $order->shipment->package_height))
					<p class="form-control-static">
						{{ $order->shipment->package_length }} x {{ $order->shipment->package_width }} x {{ $order->shipment->package_height }} cm
					</p>
				@else
					<p>Unspecified</p>
				@endif
			</div>
			<div class="form-group">
				<label>Package Weight</label>
				@if(isset($order->shipment->package_weight))
					<p class="form-control-static">{{ $order->shipment->package_weight }} grams</p>
				@else
					<p class="form-control-static">Unspecified</p>
				@endif
			</div>
		</div>
	</div>
	@endif

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