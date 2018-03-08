{!! Form::open([
	'url' => route('movement.rollback', $entry->getKey()),
	'method' => 'POST',
]) !!}
	<button class="btn btn-xs btn-default" title="Rollback this movement." type="submit" ><i class="fa fa-undo"></i> Rollback</button>
{!! Form::close() !!}

{{-- @if ($crud->hasAccess('delete'))
	<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-undo"></i> {{ trans('backpack::crud.rollback') }}</a>
@endif --}}