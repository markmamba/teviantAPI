@extends('pdf.layout')

@section('content')

<table>
	<tr>
		<td>
			<h1>Teviant <small>Purchase Order</small></h1>
		</td>
		<td><h1>{{ $purchase_order->supplier->name }}</h1></td>
	</tr>
</table>

<br>

<table>
	<tbody>
		<tr>
			<td>Purchase Order #{{ $purchase_order->id }}</td>
			<td>Date: {{ $purchase_order->created_at }}</td>
		</tr>
		<tr>
			<td>
				<strong>Ship to:</strong>
				<br>
				Teviant Address
			</td>
			<td>
				<strong>Bill to:</strong>
				<br>
				Teviant Address
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
		@foreach($purchase_order->products as $product)
			<tr>
				<td>{{ $product->inventory->sku_code }}</td>
				<td>{{ $product->inventory->name }}</td>
				<td>{{ number_format($product->quantity) }}</td>
				<td class="text-right">{{ number_format($product->price) }}</td>
			</tr>
		@endforeach
		<tr>
			<td class="text-right" colspan="3">Total</td>
			<td class="text-right">{{ number_format($purchase_order->price_total) }}</td>
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