<!-- select2 -->
<div clas="form-group col-md-12">

    <?php $entity_model = $crud->model; ?>
    <select 
        ng-model="item.{{ $field['name'] }}"
        style="width: 100%" 
        ng-init="setProducts( {{ $field['model']::all() }} )"
        ng-change="getIndex(item.{{ $field['name'] }}, item)"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_pivot'])
        >
            <option value="">-</option>

            @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                <option ng-value="{{ $connected_entity_entry->getKey() }}" ng-selected="item.id == {{$connected_entity_entry->getKey()}} || item.product_id == {{$connected_entity_entry->getKey()}} " onclick="item.price = {{$connected_entity_entry->getKey()}}">{{ $connected_entity_entry->{$field['attribute']} }} {{' '}} {{$connected_entity_entry->name}}</option>
            @endforeach
            @endif
    </select>
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif


</div>

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
@push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2_pivot').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: "bootstrap"
                    });
                }
            });
        });
    </script>
@endpush
