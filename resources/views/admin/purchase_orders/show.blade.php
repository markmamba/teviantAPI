@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    <span>{{ title_case($crud->entity_name) }} #{{ $purchase_order->id }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')

	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">General</h3>
		</div>
		<div class="box-body">
			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Purchase Order #</label>
					<div class="col-sm-10">
						<p class="form-control-static">{{ $purchase_order->id }}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Supplier</label>
					<div class="col-sm-10">
						<p class="form-control-static">{{ $purchase_order->supplier->name }}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Remark</label>
					<div class="col-sm-10">
						<p class="form-control-static">{{ $purchase_order->remark }}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date Created</label>
					<div class="col-sm-10">
						<p class="form-control-static">{{ $purchase_order->created_at }} ({{ $purchase_order->created_at->diffForHumans() }})</p>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Products</h3>
		</div>
		<div class="box-body">
			<table class="table table-responsive">
				<thead>
					<th>SKU</th>
					<th>Inventory</th>
					<th>Price</th>
					<th>Quantity</th>
					<th class="text-right">Subtotal</th>
				</thead>
				<tbody>
					@foreach($purchase_order->products as $product)
						<tr>
							<td>{{ $product->inventory->sku_code }}</td>
							<td>{{ $product->inventory->name }}</td>
							<td>{{ number_format($product->price) }}</td>
							<td>{{ $product->quantity }}</td>
							<td class="text-right">{{ number_format($product->price * $product->quantity) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<p class="text-right"><strong>Total: {{ number_format($purchase_order->price_total) }}</strong></p>
		</div>
	</div>

	<a href="{{ route('crud.purchase-order.index') }}">
		<i class="fa fa-angle-double-left"></i> Back to all {{ str_plural(title_case($crud->entity_name)) }}
	</a>

@endsection


@section('after_styles')
	{{--  --}}
@endsection

@section('after_scripts')
	{{--  --}}
@endsection