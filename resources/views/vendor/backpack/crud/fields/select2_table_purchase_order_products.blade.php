<?php
    $parent_model_items = \App\Models\PurchaseOrder::with(['products', 'products.inventory'])->get();
    $parent_model_items_plucked = $parent_model_items->map(function($purchase_order){
        return collect($purchase_order->only([
            'id',
        ]))
        ->merge([
            'products' => $purchase_order->products->map(function($product){
                return collect($product->only([
                    'id'
                ]))
                ->merge([
                    'name' => $product->inventory->name,
                    'sku' => $product->inventory->sku_code
                ]);
            })
        ]);
    });
?>

<!-- select2 -->
<div ng-app="select2TableApp" ng-controller="purchaseOrderController" @include('crud::inc.field_wrapper_attributes') >
    
    <select ng-model="purchase_order.id">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <p>PO #<% purchase_order.id %></p>

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->model; ?>

    <ui-select ng-model="ctrl.person.selected" theme="select2" ng-disabled="ctrl.disabled" style="min-width: 300px;" title="Choose a person" append-to-body="true">
      <ui-select-match placeholder="Select a person in the list or search his name/age..."><% $select.selected.name %></ui-select-match>
      <ui-select-choices repeat="person in ctrl.people | propsFilter: {name: $select.search, age: $select.search}">
        <div ng-bind-html="person.name | highlight: $select.search"></div>
        <small>
          email: <% person.email %>
          age: <span ng-bind-html="''+person.age | highlight: $select.search"></span>
        </small>
      </ui-select-choices>
    </ui-select>

    <select ng-model="purchase_order.id"
        name="{{ $field['name'] }}"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control _select2_field'])
        >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                @if(old($field['name']) == $connected_entity_entry->getKey() || (is_null(old($field['name'])) && isset($field['value']) && $field['value'] == $connected_entity_entry->getKey()))
                    <option value="{{ $connected_entity_entry->getKey() }}" selected>{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @else
                    <option value="{{ $connected_entity_entry->getKey() }}">{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        {{-- <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="/bower_components/angular-ui-select/dist/select.min.css">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script> --}}
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script> --}}
        <script type="text/javascript" src="/bower_components/angular/angular.min.js"></script>
        <script type="text/javascript" src="/bower_components/angular-ui-select/dist/select.min.js"></script>
        
        <script>
            window.angularApp = window.angularApp || angular.module('select2TableApp', ['ui.select'], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('purchaseOrderController', function($scope){

                $scope.purchase_orders = JSON.parse(JSON.stringify({!! $parent_model_items_plucked->toJson() !!}));
                $scope.purchase_order  = {
                    id: null,
                    products: {}
                };

            });

            // angular.element(document).ready(function(){
            //     angular.forEach(angular.element('[ng-app]'), function(ctrl){
            //         var ctrlDom = angular.element(ctrl);
            //         if( !ctrlDom.hasClass('ng-scope') ){
            //             angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
            //         }
            //     });
            // })

        </script>
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}