@extends('pdf.layout')

@section('content')

<table>
	<tr>
		<td colspan="2">
			<h1>Teviant <small>Transfer Order</small></h1>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Order #{{ $transfer_order->id }}</strong>
		</td>
		<td>Date: {{ $transfer_order->created_at }}</td>
	</tr>
</table>

<br>

<h4>Products</h4>
<table>
	<thead>
		<tr>
			<th>SKU</th>
			<th>Name</th>
			<th>Quantity</th>
			<th>Location</th>
			<th>Ailse-Row-Bin</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $transfer_order->product->inventory->sku_code }}</td>
			<td>{{ $transfer_order->product->inventory->name }}</td>
			<td>{{ $transfer_order->quantity }}</td>
			<td>{{ $transfer_order->location->name }}</td>
			<td>{{ $transfer_order->ailse_row_bin or 'unspecified'}}</td>
		</tr>
	</tbody>
</table>

<br>

<table>
	<tr>
		<td>
			Transfer Date:
		</td>
		<td>
			Transferred By:
		</td>
	</tr>	
</table>

@endsection