<!-- number input -->
<div ng-app="TransferOrdersQuantityFieldApp" ng-controller="TransferOrdersQuantityFieldController as controller" @include('crud::inc.field_wrapper_attributes') >
    <label for="{{ $field['name'] }}">{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
          type="number"
          name="{{ $field['name'] }}"
            id="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
            min="1"
            max="<% controller.quantity_max %>"
          >
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif

    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    <p class="help-block">Maximum of <% controller.quantity_max %></p>
</div>



@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

  @push('crud_fields_styles')
      <!-- no styles -->
  @endpush


  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

  @push('crud_fields_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>

    <script>  
    window.angularApp = window.angularApp || angular.module('TransferOrdersQuantityFieldApp', [], function($interpolateProvider){
      $interpolateProvider.startSymbol('<%');
      $interpolateProvider.endSymbol('%>');
    });

    window.angularApp.controller('TransferOrdersQuantityFieldController', function($scope, $document, $http, $filter){
      var vm = this;
      vm.purchase_order_product_id_selection = $document.find("select[name='purchase_order_product_id']");
      vm.purchase_order_product_id = vm.purchase_order_product_id_selection.val();
      vm.quantity_max = 0;
      vm.products = [];
      vm.product = null;

      // Handle purchase_order_id field changes
      vm.purchase_order_product_id_selection.change(function() {
        // Dev logs
        // console.log(vm.products);
        // console.log('product_id: ' + $(this).val());
        // console.log($filter('filter')(vm.products, {'product_id': $(this).val()})[0].total_quantity_transferrable);
        // console.log('quantity_max: ' + vm.quantity_max);
        // console.log('vm.purchase_order_product_id = ' + vm.purchase_order_product_id);

        vm.purchase_order_product_id = $(this).val();
        vm.product = $filter('filter')(vm.products, {'product_id': parseInt($(this).val())})[0];

        // Set maximum quantity based on product selection.
        if (vm.product != undefined)
          vm.quantity_max = $filter('filter')(vm.products, {'product_id': parseInt($(this).val())})[0].total_quantity_transferrable;
        else
          vm.quantity_max = 0;

        // Force-apply changes to the vm variables
        $that = $(this);
        $scope.$apply(function(){
          vm.purchase_order_product_id = $that.val();
        });
      });

      // Get the list of receivings products
      $http.get('{{ route('purchase_order_products.index') }}')
        .then(
          function successCallback(response) {
            vm.products = response.data;
          },
          function errorCallback(response) {
            console.log(response.data);
          }
        );
    });

    </script>
  @endpush
@endif

{{-- Note: most of the times you'll want to use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load CSS/JS once, even though there are multiple instances of it. --}}