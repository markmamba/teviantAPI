{!! Form::open(['url' => route('movement.rollback', $entry->getKey()), 'method' => 'POST']) !!}
	{{-- <a href="{{ route('movement.rollback', $entry->getKey()) }}" class="btn btn-xs btn-default" title="Remove some stock" data-toggle="tooltip"><i class="fa fa-undo"></i> Rollback</a> --}}
	<button class="btn btn-xs btn-default" title="Rollback this movement."><i class="fa fa-undo"></i> Rollback</button>
{!! Form::close() !!}

{{-- @if ($crud->hasAccess('delete'))
	<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-undo"></i> {{ trans('backpack::crud.rollback') }}</a>
@endif --}}