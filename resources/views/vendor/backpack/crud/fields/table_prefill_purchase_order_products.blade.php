<!-- array input -->

<?php
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
<div ng-app="backPackTableApp" ng-controller="PurchaseOrderController" @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    {{-- <input type="text" class="form-control" ng-model="purchase_order[0].products | json"> --}}
    <input class="array-json hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}" ng-model="purchase_order[0].products | json">

    <div class="array-container form-group">

        <table class="table table-bordered table-striped m-b-0">

            {{-- debug --}}
            {{-- <p>Purchase Order:</p>
            <p><% purchase_order %></p>
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
            </ul> --}}
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

            <tbody ui-sortable="sortableOptions" class="table-striped">

                <tr ng-repeat="product in purchase_order[0].products" class="array-row">
                    <td>
                        <p><% product.sku %></p>
                        {{-- <input class="form-control input-sm" type="text" ng-model="product.sku" disabled> --}}
                    </td>
                    <td>
                        <p><% product.name %></p>
                        {{-- <input class="form-control input-sm" type="text" ng-model="product.name" disabled> --}}
                    </td>
                    <td>
                        <input class="form-control input-sm" type="number" ng-model="product.quantity" required>
                    </td>
                    <td ng-if="max == -1 || max > 1">
                        <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                    </td>
                </tr>

            </tbody>

        </table>

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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>
          
            window.angularApp = window.angularApp || angular.module('backPackTableApp', [], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('PurchaseOrderController', function($scope, $document){
                
                // TODO: use controllerAs with vm style later.
                var vm = this;
                $scope.purchase_order_id_selection = $document.find("select[name='purchase_order_id']");
                $scope.purchase_orders = JSON.parse(JSON.stringify({!! $parent_model_items_plucked->toJson() !!}));
                $scope.purchase_order  = {
                    id: $scope.purchase_order_id_selection.val(),
                    products: [{}],
                    quantity: null
                };
                $scope.purchase_order = $scope.purchase_orders.filter(filterPurchaseOrderProduct);
                $scope.{{ $field['name'] }} = angular.toJson($scope.purchase_order[0].products);

                // Handle purchase_order_id field changes
                $scope.purchase_order_id_selection.change(function() {
                    $that = $(this);
                    $scope.$apply(function(){
                        $scope.purchase_order.id = $that.val();
                        $scope.purchase_order = $scope.purchase_orders.filter(filterPurchaseOrderProduct);
                        $scope.{{ $field['name'] }} = angular.toJson($scope.purchase_order[0].products);
                        console.log($scope.purchase_order);
                    });
                });
                
                function filterPurchaseOrderProduct(purchase_order) {
                    return purchase_order.id == $scope.purchase_order.id
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
