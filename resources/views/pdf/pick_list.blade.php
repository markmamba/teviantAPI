@extends('pdf.layout')

@section('content')

<h1>Pick List <small>Order #{{ $order->id }}</small></h1>

<table>
	<thead>
		<tr>
			<th></th>
			<th>SKU</th>
			<th>Name</th>
			<th>Quantity</th>
			<th>Location</th>
			<th>Aisle-Row-Bin</th>
			<th>Reserved</th>
		</tr>
	</thead>
	<tbody>
		@foreach($order->reservations as $reservation)
			<tr>
				<td class="text-center"><input type="checkbox"></td>
				<td>{{ $reservation->stock->item->sku_code }}</td>
				<td>{{ $reservation->stock->item->name }}</td>
				<td>{{ $reservation->order_product->quantity }}</td>
				<td>{{ $reservation->stock->location->name }}</td>
				<td>{{ $reservation->stock->aisle }}-{{ $reservation->stock->row }}-{{ $reservation->stock->bin }}</td>
				<td>{{ $reservation->quantity_reserved }}/{{ $reservation->order_product->quantity }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection