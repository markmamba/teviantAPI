@extends('pdf.layout')

@section('content')

{{-- Pick List Page --}}

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

{{-- Receipt page --}}

<div class="page-break"></div>

<h1>Receipt</h1>

<table>
	<tbody>
		<tr>
			<td>Order #{{ $order->id }}</td>
			<td>Date Ordered: {{ $order->created_at }}</td>
		</tr>
		<tr>
			<td>
				<strong>Ship to:</strong>
				<br>
				{{ $order->full_shipping_address }}
			</td>
			<td>
				<strong>Bill to:</strong>
				<br>
				{{ $order->full_billing_address }}
			</td>
		</tr>
	</tbody>
</table>

<table>
	<caption>Items</caption>
	<thead>
		<tr>
			<th>SKU</th>
			<th>Name</th>
			<th>Quantity</th>
			<th class="text-right">Price</th>
		</tr>
	</thead>
	<tbody>
		@foreach($order->reservations as $reservation)
			<tr>
				<td>{{ $reservation->stock->item->sku_code }}</td>
				<td>{{ $reservation->stock->item->name }}</td>
				<td>{{ $reservation->order_product->quantity }}</td>
				<td class="text-right">{{ $reservation->order_product->price }}</td>
			</tr>
		@endforeach
		<tr>
			<td class="text-right" colspan="3">Total</td>
			<td class="text-right">{{ $reservation->order_product->order->products->sum('price') }}</td>
		</tr>
	</tbody>
</table>

<br>

<table>
	<tbody>
		<tr>
			<td>Received by:</td>
			<td>Date:</td>
		</tr>
	</tbody>
</table>

@endsection