@can('movements.rollback')
{{-- {!! Form::open([
	'url' => route('movement.rollback.form', $entry->getKey()),
	'method' => 'POST',
	'class' => 'movements_rollback_form'
]) !!}
	<button class="btn btn-xs btn-default" title="Rollback this movement." type="submit" ><i class="fa fa-undo"></i> Rollback</button>
{!! Form::close() !!} --}}
<a href="{{ route('movement.rollback', $entry->getKey()) }}" class="btn btn-xs btn-default">
	<i class="fa fa-undo"></i> Rollback
</a>
@endcan

{{-- @if ($crud->hasAccess('delete'))
	<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-undo"></i> {{ trans('backpack::crud.rollback') }}</a>
@endif --}}

{{-- @section('after_scripts')
	<script>
		$(document).ready(function() {
			$(".movements_rollback_form").click(function(event) {
				if(!confirm('Are you sure to rollback?') ){
					event.preventDefault();
				}
			});
		});
	</script>
@endsection --}}