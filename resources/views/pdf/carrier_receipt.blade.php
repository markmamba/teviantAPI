@extends('pdf.layout')

@section('content')

<table>
	<tr>
		<td><h1>Carrier Receipt</h1></td>
		<td><h1>{{ $order->carrier->name }}</h1></td>
	</tr>
</table>

<br>

<table>
	<tbody>
		<tr>
			<td>
				Teviant Ref #: {{ $order->id }}
				<br>
				Carrier Ref #: {{ $order->id }}
			</td>
			<td>Date: ____________</td>
		</tr>
		<tr>
			<td>
				<strong>Ship to:</strong>
				<br>
				{{ $order->full_shipping_address }}
			</td>
			<td>
				<strong>Customer:</strong>
				<br>
				{{ $order->fullUserName }}
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