@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span>
	    	{{ title_case($crud->entity_name) }} #{{ $order->common_id }}
	    </span>
	    <small>
	    	@if($order->status->name == 'Pending')
				<span class="label label-warning">Pending</span>
			@endif
			@if($order->status->name == 'Partial')
				<span class="label label-info">Partial</span>
			@endif
			@if($order->status->name == 'Pick Listed')
				<span class="label label-primary">Pick-Packing</span>
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
		<div class="col-md-6">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">General Details</h3>
				</div>
				<div class="box-body">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label">Order #</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ $order->common_id }}</p>
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Date Ordered</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ $order->created_at }} <span class="text-muted">({{ $order->created_at->diffForHumans() }})</span></p>
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Customer</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ $order->full_user_name }}</p>
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Items</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ $order->products->count() }}</p>
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Total</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ number_format($order->total, 2) }}</p>
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Status</label>
						    <div class="col-sm-9">
						      	<p class="form-control-static">{{ $order->status->name }}</p>
						    </div>
						</div>
					</form>

					{{-- Status recommendations or alerts --}}
					@if($order->isSufficient())
						@if($order->status->name == 'Packed')
							<p class="alert alert-info">Ready for shipping.</p>
						@elseif($order->status->name == 'Shipped')
							<p class="alert alert-info">Awaiting delivery.</p>
						@endif
					@elseif(!in_array($order->status->name, ['Cancelled']))
						<p class="alert alert-warning">Insufficient stocks. Check details below.</p>
					@endif

				</div>
				<div class="box-footer text-right">
					{{-- <div class=""> --}}
						{{-- 
							Show the appropriate primary button according to the order's current status
							- Pending
							- Partial
							- Pick Listed
							- Packed
							- Shipped
							- Delivered
							- Cancelled
						 --}}
						@if($order->status->name == 'Pending')
							@if($order->isSufficient())
								{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', 'style' => 'display: inline-block;']) !!}
									{!! Form::hidden('status_id', $order_status_options->search('Pick Listed')) !!}
									{!! Form::submit('Set as Pick-listed', ['class' => 'btn btn-primary btn-flat']) !!}
								{!! Form::close() !!}
							@else
								<div style="display: inline-block;">
									<a href="#" class="btn btn-primary btn-flat" disabled>Set as Pick-listed</a>
								</div>
							@endif
						@endif
						<div style="display: inline-block;">
							@if($order->hasPickableReservations() && !in_array($order->status->name, ['Done', 'Cancelled']))
								<a href="{{ route('order.get_reservations', $order->id) }}" class="btn btn-primary btn-flat btn-flat">Pick Products</a>
							@endif
							@if($order->hasPackableReservations())
								<a href="{{ route('order.reservations.get_pack', $order->id) }}" class="btn btn-primary btn-flat btn-flat">Pack Products</a>
							@endif
							@if($order->hasShippableReservations())
								<a href="{{ route('order.packages.get_ship', [$order->id, $order->packages->first()->id]) }}" class="btn btn-primary btn-flat btn-flat">Ship Package</a>
							@endif
							{{-- @if($order->status->name == 'Pick Listed')
								<a href="{{ route('order.pack', $order->id) }}" class="btn btn-primary btn-flat">Pack Order</a>
							@endif
							@if($order->status->name == 'Packed')
								<a href="{{ route('order.ship', $order->id) }}" class="btn btn-primary btn-flat">Ship Order</a>
							@endif --}}
						</div>
						@if($order->status->name == 'Shipped')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', 'style' => 'display: inline-block;']) !!}
								@if(!$auto_done_after_delivered)
									{!! Form::hidden('status_id', $order_status_options->search('Delivered')) !!}
								@else
									{!! Form::hidden('status_id', $order_status_options->search('Done')) !!}
								@endif
								{!! Form::submit('Set as Delivered', ['class' => 'btn btn-primary btn-flat']) !!}
							{!! Form::close() !!}
						@endif
						@if($order->isDelivered() && $order->status->name != 'Done')
							{!! Form::open(['route' => ['crud.order.update', $order->id], 'method' => 'PATCH', 'style' => 'display: inline-block;']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Done')) !!}
								{!! Form::submit('Set as Done', ['class' => 'btn btn-primary btn-flat']) !!}
							{!! Form::close() !!}
						@endif

						{{-- Cancel button --}}
						@if($order->status->name != 'Done' && $order->status->name != 'Cancelled')
							{!! Form::open(['route' => ['order.cancel', $order->id], 'method' => 'PATCH',
								'onsubmit' => 'return confirm("Are you sure to Cancel the order?");', 'style' => 'display: inline-block;']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Cancelled')) !!}
								{!! Form::submit('Cancel Order', ['class' => 'btn btn-default btn-flat']) !!}
							{!! Form::close() !!}
						@endif
						{{-- Reopen button --}}
						{{-- @if($order->status->name == 'Done' || $order->status->name == 'Cancelled')
							{!! Form::open(['route' => ['order.reopen', $order->id], 'method' => 'PATCH'
								'onsubmit' => 'return confirm("Are you sure to Cancel the order?");']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Pending')) !!}
								{!! Form::submit('Re-open Order', ['class' => 'btn btn-default']) !!}
							{!! Form::close() !!}
						@endif --}}
					{{-- </div> --}}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Address</h3>
					<div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
		                </button>
		            </div>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Shipping Address</th>
							<th>Billing Address</th>
						</thead>
						<tr>
							<td>Contact Person</td>
							<td>{{ $order->shipping_address['name'] }}</td>
							<td>{{ $order->billing_address['name'] }}</td>
						</tr>
						<tr>
							<td>Unit/Room No.</td>
							<td>{{ $order->shipping_address['unit'] }}</td>
							<td>{{ $order->billing_address['unit'] }}</td>
						</tr>
						<tr>
							<td>Building</td>
							<td>{{ $order->shipping_address['building'] }}</td>
							<td>{{ $order->billing_address['building'] }}</td>
						</tr>
						<tr>
							<td>Street</td>
							<td>{{ $order->shipping_address['street'] }}</td>
							<td>{{ $order->billing_address['street'] }}</td>
						</tr>
						<tr>
							<td>Barangay</td>
							<td>{{ $order->shipping_address['barangay'] }}</td>
							<td>{{ $order->billing_address['barangay'] }}</td>
						</tr>
						<tr>
							<td>City</td>
							<td>{{ $order->shipping_address['city'] }}</td>
							<td>{{ $order->billing_address['city'] }}</td>
						</tr>
						<tr>
							<td>Province/County</td>
							<td>{{ $order->shipping_address['county'] }}</td>
							<td>{{ $order->billing_address['county'] }}</td>
						</tr>
						<tr>
							<td>Postal Code</td>
							<td>{{ $order->shipping_address['postal_code'] }}</td>
							<td>{{ $order->billing_address['postal_code'] }}</td>
						</tr>
						<tr>
							<td>State</td>
							<td>{{ $order->shipping_address['state'] }}</td>
							<td>{{ $order->billing_address['state'] }}</td>
						</tr>
						<tr>
							<td>Country</td>
							<td>{{ isset($order->shipping_address['country']) ? $order->shipping_address['country']['name'] : null }}</td>
							<td>{{ isset($order->billing_address['country']) ? $order->shipping_address['country']['name'] : null }}</td>
						</tr>
						<tr>
							<td>Mobile Phone</td>
							<td>{{ $order->shipping_address['mobile_phone'] }}</td>
							<td>{{ $order->billing_address['mobile_phone'] }}</td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>{{ $order->shipping_address['phone'] }}</td>
							<td>{{ $order->billing_address['phone'] }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Products</h3>
				</div>
				<div class="box-body">
				<table class="table table-hover table-responsive">
					<thead>
						<th>Product</th>
						<th>SKU</th>
						<th class="text-right">Quantity</th>
						<th class="text-right">Reservations</th>
						<th class="text-right">Price</th>
					</thead>
					<tbody>
						@foreach($order->products as $product)
							<tr class="{{ $product->isFullyReserved() ? 'success' : 'danger' }}">
								<td>{{ $product->name }}</td>
								<td>{{ $product->sku }}</td>
								<td class="text-right">{{ number_format($product->quantity) }}</td>
								<td class="text-right">
									{{ $product->quantity_reserved }}/{{ $product->quantity }}
								</td>
								<td class="text-right">{{ number_format($product->price, 2) }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" class="text-right">Total Quantity: <strong>{{ number_format($order->products()->sum('quantity')) }}</strong></td>
							<td colspan="4" class="text-right">Total Price: <strong>{{ number_format($order->total, 2) }}</strong></td>
						</tr>
					</tfoot>
				</table>
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
						</div>
						<div class="col-md-9 text-right">
							<div class="btn-group">
								<button class="btn btn-default btn-flat dropdown-toggle" type="button" id="printDropdownButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-print"></i> Print <span class="caret"></span></button>
								<ul class="dropdown-menu" aria-labelledby="printDropdownButtons">
									<li>
										<a href="{{ route('order.print_pick_list', $order->id) }}" target="_blank">Pick List</a>
									</li>
									<li>
										<a href="{{ route('order.print_receipt', $order->id) }}" target="_blank">Official Receipt</a>
									</li>
									<li>
										<a href="{{ route('order.print_delivery_receipt', $order->id) }}" target="_blank">Delivery Receipt</a>
									</li>
									<li>
										<a href="{{ route('order.print_carrier_receipt', $order->id) }}" target="_blank">Carrier Receipt</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a href="{{ route('order.print_all', $order->id) }}" target="_blank">Print All</a>
									</li>
								</ul>
							</div>
							@if($order->hasPickableReservations() && !in_array($order->status->name, ['Done', 'Cancelled']))
								<a href="{{ route('order.get_reservations', $order->id) }}" class="btn btn-default btn-flat btn-flat"><i class="fa fa-hand-lizard-o"></i> Pick Products</a>
							@else
								<a class="btn btn-default btn-flat btn-flat" disabled><i class="fa fa-hand-lizard-o"></i> Pick Products</a>
							@endif
							@if($order->hasPackableReservations())
								<a href="{{ route('order.reservations.get_pack', $order->id) }}" class="btn btn-default btn-flat btn-flat"><i class="fa fa-cube"></i> Pack Products</a>
							@else
								<a class="btn btn-default btn-flat btn-flat" disabled><i class="fa fa-cube"></i> Pack Products</a>
							@endif
						</div>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-hover table-responsive">
						<thead>
							<th>Product</th>
							<th>SKU</th>
							<th>Quantity</th>
							<th>Location</th>
							<th>Aisle-Row-Bin</th>
							<th>Reserved</th>
							<th>Picked</th>
							<th>Picker</th>
							<th>Date Picked</th>
							<th class="text-right">Deficiency</th>
						</thead>
						<tbody>
							{{-- Products with reservations --}}
							@foreach($order->reservations->groupBy('order_product_id') as $key => $item)
								@foreach($item as $reservation)
									<tr>
										<td>{{ $reservation->stock->item->name }}</td>
										<td>{{ $reservation->stock->item->sku_code }}</td>
										<td>{{ $reservation->order_product->quantity }}</td>
										<td>{{ $reservation->stock->location->name }}</td>
										<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
										<td>{{ $reservation->quantity_reserved }}/{{ $reservation->order_product->quantity }}</td>
										<td>{{ $reservation->total_picked }}/{{ $reservation->order_product->quantity }}</td>
										<td>{{ $reservation->pickings->first()->picker->name or null }}</td>
										<td>{{ $reservation->picked_at or null }}</td>
										<td rowspan="{{ $item->count() }}" class="text-right">
											{{ $reservation->order_product->quantity - $reservation->order_product->reservations->sum('quantity_reserved')}}
										</td>
									</tr>
								@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	{{-- Shipments Panel --}}
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Packages</h3>
		</div>
		<div class="box-body">
		<table class="table table-hover">
			<thead>
				<th>Carrier</th>
				<th>Invoice #</th>
				<th>Tracking #</th>
				<th>Status</th>
				<th>Date Packed</th>
				<th>Date Shipped</th>
				<th>Date Delivered</th>
				<th class="text-right"></th>
			</thead>
			<tbody>
				@foreach($order->packages as $package)
					<tr>
						<td>{{ $package->carrier->name ?? null }}</td>
						<td>{{ $package->sales_invoice_number ?? null }}</td>
						<td>{{ $package->tracking_number ?? null }}</td>
						<td>
							@if(!isset($package->shipped_at))
								<span class="label label-warning">For Shipping</span>
							@elseif(isset($package->shipped_at) && $package->delivered_at == null)
								<span class="label label-primary">Shipping</span>
							@elseif(isset($package->delivered_at))
								<span class="label label-success">Delivered</span>
							@endif
						</td>
						<td>{{ $package->created_at }}</td>
						<td>{{ $package->shipped_at ?? null }}</td>
						<td>{{ $package->delivered_at ?? null }}</td>
						<td class="text-right">
							<div class="form-inline">
							@if($package->shipped_at == null && $package->delivered_at == null)
								<a href="{{ route('order.packages.get_ship', [$order->id, $package->id]) }}" class="btn btn-default btn-flat btn-flat"><i class="fa fa-truck"></i> Ship</a>
							@else
								<a class="btn btn-default btn-flat btn-flat" disabled><i class="fa fa-truck"></i> Ship</a>
							@endif
							@if(isset($package->shipped_at) && $package->delivered_at == null)
								{!! Form::open(['url' => route('order.packages.deliver', [$order->id, $package->id]), 'method' => 'patch', 'style' => 'display:inline-block;',
									'onsubmit' => 'return confirm("Please confirm to proceed.");']) !!}
									<button class="btn btn-default btn-flat"><i class="fa fa-check-square-o"></i> Delivered</button>
								{!! Form::close() !!}
							@else
								<button class="btn btn-default btn-flat" disabled><i class="fa fa-check-square-o"></i> Delivered</button>
							@endif
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
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