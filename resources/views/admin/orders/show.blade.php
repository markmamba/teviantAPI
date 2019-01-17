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
		<div class="col-md-6">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">General Details</h3>
				</div>
				<div class="box-body">
					<h5>Order Id</h5>
					{{ $order->common_id }}
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
		<div class="col-md-6">
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
								@if(!$auto_done_after_delivered)
									{!! Form::hidden('status_id', $order_status_options->search('Delivered')) !!}
								@else
									{!! Form::hidden('status_id', $order_status_options->search('Done')) !!}
								@endif
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
						{{-- @if($order->status->name == 'Done' || $order->status->name == 'Cancelled')
							{!! Form::open(['route' => ['order.reopen', $order->id], 'method' => 'PATCH']) !!}
								{!! Form::hidden('status_id', $order_status_options->search('Pending')) !!}
								{!! Form::submit('Re-open Order', ['class' => 'form-control btn btn-default']) !!}
							{!! Form::close() !!}
						@endif --}}
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
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
								@if($order->status->name == 'Packed')
									<p class="text-success">Ready for shipping.</p>
								@elseif($order->status->name == 'Shipped')
									<p class="text-success">Awaiting delivery.</p>
								@endif
							@else
								<p class="text-warning">Insufficient stocks. Replenish stocks!</p>
							@endif
						</div>
						<div class="col-md-9">
							<div class="pull-right">
								
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="printDropdownButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-print"></i> Print <span class="caret"></span></button>
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
							</div>
						</div>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-responsive">
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
						</thead>
						@foreach($order->reservations->groupBy('order_product_id') as $key => $item)
							<tbody>
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
								</tr>
							@endforeach
								<tr>
									<td class="text-right" colspan="9">
										<strong>Item deficiency:</strong> 
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