<?php
	$quantity_available = $entry->quantityAvailable();
?>
@if($quantity_available > \Config::get('settings.inventory_low_stock_level'))
	<span class="label label-success">{{ $quantity_available }}</span>
@elseif($quantity_available <= \Config::get('settings.inventory_low_stock_level') && $quantity_available > 0)
	<span class="label label-warning">{{ $quantity_available }}</span>
@else
	<span class="label label-danger">{{ $quantity_available }}</span>
@endif