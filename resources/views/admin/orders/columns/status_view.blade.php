@if($entry->status->name == 'Pending')
	<span class="label label-warning">Pending</span>
@endif
@if($entry->status->name == 'Partial')
	<span class="label label-info">Paritial</span>
@endif
@if($entry->status->name == 'Pick Listed')
	<span class="label label-warning">For Picking</span>
@endif
@if($entry->status->name == 'Packed')
	<span class="label label-warning">For Shipping</span>
@endif
@if($entry->status->name == 'Shipped')
	<span class="label label-primary">Shipping</span>
@endif
@if($entry->status->name == 'Delivered' || $entry->status->name == 'Done')
	<span class="label label-success">Completed</span>
@endif
@if($entry->status->name == 'Cancelled')
	<span class="label label-danger">Cancelled</span>
@endif