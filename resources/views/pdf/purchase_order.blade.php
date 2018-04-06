@extends('pdf.layout')

@section('content')

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