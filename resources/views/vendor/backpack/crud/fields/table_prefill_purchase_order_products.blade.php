<!-- array input -->

<?php
    $max = isset($field['max']) && (int) $field['max'] > 0 ? $field['max'] : -1;
    $min = isset($field['min']) && (int) $field['min'] > 0 ? $field['min'] : -1;
    $item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if (is_array($items)) {
        if (count($items)) {
            $items = json_encode($items);
        } else {
            $items = '[]';
        }
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

    $parent_model_items = $field['parent_model']::with(['products', 'products.inventory'])->get();
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

    // echo 'Debugging<hr>';
    // dd(
    //     $items,
    //     $field['parent_model']::all(),
    //     $parent_model_items,
    //     $parent_model_items_plucked->toArray()
    // );
    // die();

?>
<div ng-app="backPackTableApp" ng-controller="tableController" @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

        <table class="table table-bordered table-striped m-b-0" ng-init="field = '#{{ $field['name'] }}'; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'">

            <p>Order #<% purchase_order.id %></p>
            <ul ng-repeat="purchase_order in purchase_orders">
                <li>
                    Order #<% purchase_order.id %>
                    <br>
                    Products:
                    <ul ng-repeat="product in purchase_order.products">
                        <li>
                            <% product.sku %> - <% product.name %>
                        </li>
                    </ul>
                </li>
            </ul>

            <thead>
                <tr>

                    @foreach( $field['columns'] as $prop )
                    <th style="font-weight: 600!important;">
                        {{ $prop }}
                    </th>
                    @endforeach
                    <th class="text-center" ng-if="max == -1 || max > 1"> <i class="fa fa-sort"></i></th>
                    {{-- <th class="text-center" ng-if="max == -1 || max > 1"> <i class="fa fa-trash"></i></th> --}}
                </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

                <tr ng-repeat="product in purchase_order.products" class="array-row">

                    {{-- @foreach( $field['columns'] as $prop => $label)
                        <td>
                            <input class="form-control input-sm" type="text" ng-model="item.{{ $prop }}">
                        </td>
                    @endforeach --}}
                    <td>
                        <input class="form-control input-sm" type="text" ng-model="item.sku">
                    </td>
                    <td>
                        <input class="form-control input-sm" type="text" ng-model="item.name">
                    </td>
                    <td>
                        <input class="form-control input-sm" type="text" ng-model="item.quantity">
                    </td>
                    <td ng-if="max == -1 || max > 1">
                        <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                    </td>
                    {{-- <td ng-if="max == -1 || max > 1">
                        <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button" ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                    </td> --}}
                </tr>

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button" ng-click="addItem()"><i class="fa fa-plus"></i> {{trans('backpack::crud.add')}} {{ $item_name }}</button>
        </div>

    </div>

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
    {{-- @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular-cookies.min.js"></script> --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>
        <script>

            console.log('Hello');
          
            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('tableController', function($scope, $document){
            // window.angularApp.controller('tableController', function($scope, $http, $cookies){

                // $http.get("/api/test")
                //     .then(function(response) {
                //         console.log(response.data);
                //         // $scope.myWelcome = response.data;
                //     });

                // console.log($cookies.get('laravel_token'));
                
                this.purchase_order_id_selection = $document.find("select[name='purchase_order_id']");

                $scope.purchase_orders = JSON.parse(JSON.stringify({!! $parent_model_items_plucked->toJson() !!}));
                $scope.purchase_order  = {
                    id: this.purchase_order_id_selection.val(),
                    products: $scope.purchase_orders.find(findPurchaseOrderProducts, this)
                };

                // Handle purchase_order_id field changes
                this.purchase_order_id_selection.change(function() {
                    $that = $(this);
                    $scope.$apply(function(){
                        $scope.purchase_order.id = $that.val();
                        // $scope.purchase_order.products = $scope.purchase_orders.find(findPurchaseOrderProducts, $scope);
                        $scope.purchase_order.products = $scope.purchase_orders.filter(function(purchase_order){
                            console.log(purchase_order);
                            if (purchase_order.id == $scope.purchase_order.id) {
                                // console.log('found' . purchase_order.products);
                                $scope.purchase_order.products = purchase_order.products;
                                return purchase_order.id == $scope.purchase_order.id
                            }
                        });
                    });

                    // console.log('purchase_order.products' . $scope.purchase_order.products);
                });

                // var item73 = myArray.filter(function(item) {
                //     return item.id === '73';
                // })[0];

                function findPurchaseOrderProducts(purchase_order, index, array){
                    // console.log(this);
                    // console.log($scope.purchase_order.id);
                    // console.log('$purchase_order.id: ' . $scope.purchase_order.id);
                    // console.log(this);
                    // if($scope.purchase_order.id == this.purchase_order_id_selection.val())
                    //     return purchase_order.products;
                }

                $scope.sortableOptions = {
                    handle: '.sort-handle',
                    axis: 'y',
                    helper: function(e, ui) {
                        ui.children().each(function() {
                            $(this).width($(this).width());
                        });
                        return ui;
                    },
                };

                $scope.addItem = function(){

                    if( $scope.max > -1 ){
                        if( $scope.items.length < $scope.max ){
                            var item = {};
                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = {};
                        $scope.items.push(item);
                    }
                }

                $scope.removeItem = function(item){
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }

                $scope.$watch('items', function(a, b){

                    if( $scope.min > -1 ){
                        while($scope.items.length < $scope.min){
                            $scope.addItem();
                        }
                    }

                    if( typeof $scope.items != 'undefined' ){

                        if( typeof $scope.field != 'undefined'){
                            if( typeof $scope.field == 'string' ){
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val( $scope.items.length ? angular.toJson($scope.items) : null );
                        }
                    }
                }, true);

                if( $scope.min > -1 ){
                    for(var i = 0; i < $scope.min; i++){
                        $scope.addItem();
                    }
                }
            });

            angular.element(document).ready(function(){
                angular.forEach(angular.element('[ng-app]'), function(ctrl){
                    var ctrlDom = angular.element(ctrl);
                    if( !ctrlDom.hasClass('ng-scope') ){
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            })

        </script>

    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
