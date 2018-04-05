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

?>
<div 
    ng-app="backPackTableApp" 
    ng-controller="tableController" 
    @include('crud::inc.field_wrapper_attributes') 
    >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

       <table class="table table-bordered table-striped m-b-0" ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}';">

            <thead>
                <tr>
                    @foreach( $field['columns'] as $column )
                    <th style="font-weight: 600!important;">
                        {{ $column['label'] }}
                    </th>
                    @endforeach
                     <th>
                        Subtotal
                    </th>
                    <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-sort"></i> --}} </th>
                </tr>
            </thead>

            <tbody ng-model="items" class="table-striped">
                <tr post-render ng-repeat="item in items" class="array-row" >

                    @foreach ($field['columns'] as $column)
                        <td 
                             class="
                                @if(isset($column['size']))  
                                    col-md-{{ $column['size'] }}
                                @endif
                                "
                            >
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        @if(view()->exists('vendor.backpack.crud.fields.'.$column['type']))
                            @include('vendor.backpack.crud.fields.'.$column['type'], array('field' => $column))
                        @else
                            @include('crud::fields.'.$column['type'], array('field' => $column))
                        @endif
                        </td>
                    @endforeach
                    <td>  
                        <div>
                            <input ng-model="item.subtotal" readonly="1" ng-value="item.pivot ? (item.pivot.price * item.pivot.quantity) : item.quantity ? (item.price * item.quantity) : 0" type="text" readonly="1" ng-pattern="/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}(?:\.[0-9]{1,2})?$/" step="0.01" class="form-control ng-pristine ng-valid ng-empty ng-valid-pattern ng-touched">
                            
                        </div>
                     </td>

                    <td ng-if="max == -1 || max > 1">
                        <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button" ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                    </td>
                </tr>

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button" ng-click="addItem()"><i class="fa fa-plus"></i> Add {{ $item_name }}</button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>
        <script>
            var total_price = 0;
            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function(){
                // $interpolateProvider.startSymbol('<%');
                // $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('tableController', function($scope){
                var products = null;
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
                $scope.getIndex = function(index,item) {
                        if(index != "undefined"){
                            var pos = $scope.products.map(function(e) { return e.id ? e.id : e.product_id; }).indexOf(parseInt(index));
                           if(pos >=0 ){
                            item.price = $scope.products[pos].price;
                           }else{
                                item.price = null;
                           }
                       }
                    }
                $scope.setProducts = function(products){
                    if($scope.products == null){
                        $scope.products = products;
                    }
                   
            
                }
                $scope.removeItem = function(item){
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }
                $scope.addOrderProduct = function(selectedItem) {
                    var index = $scope.items.indexOf(selectedItem);
                }

                $scope.$watch('items', function(a, b){
                    var tmp_total_price = 0;
                    angular.forEach(a, function(value, key) {
                        if(typeof value.pivot !== "undefined"){
                            tmp_total_price += value.pivot.price * value.pivot.quantity;
                        }else{
                            if(typeof value.price !=='undefined' && typeof value.quantity !== 'undefined'){
                                tmp_total_price += value.price * value.quantity;
                            }
                           
                        }
                    });
                    // if(typeof new_data === "undefined") {
                    //     alert("something is undefined");
                    // }
                     // console.log($("[name='total']").val(tmp_total_price));
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

                    $("[name='total']").val(tmp_total_price.toFixed(2));
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