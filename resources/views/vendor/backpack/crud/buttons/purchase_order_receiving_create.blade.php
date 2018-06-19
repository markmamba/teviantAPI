@if(!$entry->isCompleted())
	<a href="{{ route('purchase_order.crud.receiving.create', $entry->getKey()) }}" class="btn btn-xs btn-default" title="Create Receiving" data-toggle="tooltip"><i class="fa fa-download"></i> Receive</a>
@else
	<a href="#" class="btn btn-xs btn-default" title="Create Receiving" data-toggle="tooltip" disabled><i class="fa fa-download"></i> Receive</a>
@endif