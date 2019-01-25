@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">Order #{{ $order->common_id }}</span>
        <small>Reservations</small>
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
			<a href="{{ route('order.show', $order->id) }}"><i class="fa fa-angle-double-left"></i> Back to order</a><br><br>
		@endif

		@include('crud::inc.grouped_errors')

		<div class="box box-default">
			<div class="box-header">
				<h3 class="box-title">Pack Products</h3>
			</div>
			<div class="box-body">
				
				{!! Form::open(['url' => route('order.reservations.post_pack', $order->id), 'method' => 'POST', 'id' => 'orderPickingsForm']) !!}
				{!! Form::hidden('order_id', $order->id) !!}

				{{-- Sales Invoice Number --}}
				<div class="form-group">
					{!! Form::label('sales_invoice_number') !!}
					{!! Form::text('sales_invoice_number', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
				</div>

				{{-- Tracking Number --}}
				<div class="form-group">
					{!! Form::label('tracking_number') !!}
					{!! Form::text('tracking_number', null, ['class' => 'form-control', 'required' => true]) !!}
				</div>

				<table class="table table-hover table-bordered">
					<caption>Check that the package has the following products.</caption>
					<thead>
						<th>SKU</th>
						<th>Name</th>
						<th>Location</th>
						<th>Aisle-Row-Bin</th>
						<th>Quantity Reserved</th>
						<th></th>
					</thead>
					<tbody>
						@foreach($order->reservations()->forPacking()->get() as $key => $reservation)
							<tr>
								<td>{{ $reservation->stock->item->sku_code }}</td>
								<td>{{ $reservation->stock->item->name }}</td>
								<td>{{ $reservation->stock->location->name }}</td>
								<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
								<td>{{ $reservation->order_product->quantity }}/{{ $reservation->quantity_reserved }}</td>
								<td class="text-right">
									<label>
										{!! Form::hidden('reservations['.$key.'][id]', $reservation->id) !!}
										{!! Form::checkbox('reservations['.$key.'][is_picked]', true, $reservation->packed_at, ['required' => true]) !!} Packed
									</label>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! Form::close() !!}
			</div>
			<div class="box-footer text-right">
				@if($order->hasPackableReservations())
					<button type="submit" form="orderPickingsForm" class="btn btn-primary btn-flat">Confirm Package</button>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection
