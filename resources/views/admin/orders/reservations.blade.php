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
				<h3 class="box-title">Product Reservations</h3>
			</div>
			<div class="box-body">
				<table class="table table-hover table-bordered">
					<caption>Pick all the following reserved products.</caption>
					<thead>
						<th>SKU</th>
						<th>Name</th>
						<th>Location</th>
						<th>Aisle-Row-Bin</th>
						<th>Quantity Reserved</th>
						<th></th>
					</thead>
					<tbody>
						{!! Form::open(['url' => route('order.reservations.pick', $order->id), 'method' => 'POST', 'id' => 'orderPickingsForm', 'onsubmit' => 'return confirm("Are you sure the listed products have been picked?");']) !!}
						@foreach($order->reservations()->forPicking()->get() as $key => $reservation)
							<tr>
								<td>{{ $reservation->stock->item->sku_code }}</td>
								<td>{{ $reservation->stock->item->name }}</td>
								<td>{{ $reservation->stock->location->name }}</td>
								<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
								<td>{{ $reservation->order_product->quantity }}/{{ $reservation->quantity_reserved }}</td>
								<td class="text-right">
									<label>
										{!! Form::hidden('reservations['.$key.'][id]', $reservation->id) !!}
										{!! Form::checkbox('reservations['.$key.'][is_picked]', true, $reservation->picked_at, ['required' => true]) !!} Picked
									</label>
								</td>
							</tr>
						@endforeach
						{!! Form::close() !!}
					</tbody>
				</table>
			</div>
			<div class="box-footer text-right">
				@if($order->hasPickableReservations())
					<button type="submit" form="orderPickingsForm" class="btn btn-primary btn-flat">Confirm Pickings</button>
				@endif
			</div>
		</div>

		@include('crud::inc.grouped_errors')
	</div>
</div>

@endsection
