@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">Order #{{ $order->common_id }} Pickings</span>
        <small>Set Picked Products</small>
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
	<div class="col-md-12">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ route('order.show', $order->id) }}"><i class="fa fa-angle-double-left"></i> Back to order</a><br><br>
		@endif

		<div class="box box-default">
			<div class="box-header">
				<h3 class="box-title">Product Reservations</h3>
			</div>
			<table class="table table-hover table-bordered">
				<thead>
					<th>SKU</th>
					<th>Name</th>
					<th>Location</th>
					<th>Aisle-Row-Bin</th>
					<th>Quantity Reserved</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($order->reservations->groupBy('order_product_id') as $key => $item)
						@foreach($item as $reservation)
							<td>{{ $reservation->stock->item->sku_code }}</td>
							<td>{{ $reservation->stock->item->name }}</td>
							<td>{{ $reservation->stock->location->name }}</td>
							<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
							<td>{{ $reservation->order_product->quantity }}/{{ $reservation->quantity_reserved }}</td>
							<td>
								<div class="checkbox">
									<label>
										<input type="checkbox"> Picked
									</label>
								</div>
							</td>
						@endforeach
					@endforeach
				</tbody>
				<tfoot>
					<tr class="text-right">
						<td colspan="6">
							<button class="btn btn-primary btn-flat">Confirm Pickings</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>

		@include('crud::inc.grouped_errors')
	</div>
</div>

@endsection
