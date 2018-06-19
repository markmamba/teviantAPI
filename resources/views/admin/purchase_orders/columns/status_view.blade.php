@if(isset($entry->completed_at))
	<span class="label label-success">Completed</span>
@else
	<span class="label label-warning">Pending</span>
@endif