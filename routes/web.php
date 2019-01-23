<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {

    // your CRUD resources and other admin routes here
    CRUD::resource('metric', 'MetricCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    
    CRUD::resource('inventory', 'InventoryCrudController');
    Route::group(['prefix' => 'inventory/{inventory_id}', 'as' => 'inventory.'], function() {
        Route::group(['prefix' => 'stocks', 'as' => 'stocks.'], function() {
            // Add inventory stock routes
            Route::get('add', 'InventoryCrudController@getAddStock')->name('add');
            Route::post('add', 'InventoryCrudController@postAddStock')->name('post_add');

            // Remove inventory stock routes
            Route::get('remove', 'InventoryCrudController@getRemoveStock')->name('remove');
            Route::post('remove', 'InventoryCrudController@postRemoveStock')->name('post_remove');
        });
    });

    CRUD::resource('location', 'LocationCrudController');
    
    CRUD::resource('stock', 'InventoryStockCrudController');
    // !!! DIFFERENT ADMIN PANEL FOR STOCK MOVEMENTS
    Route::group(['prefix' => 'stock/{stock_id}'], function()
    {
        // Add stock routes
        Route::get('add', 'StockMovementCrudController@getAddStock')->name('get_add_stock');
        Route::post('post-add', 'StockMovementCrudController@postAddStock')->name('post_add_stock');

        // Remove stock routes
        Route::get('remove', 'StockMovementCrudController@getRemoveStock')->name('get_remove_stock');
        Route::post('post-remove', 'StockMovementCrudController@postRemoveStock')->name('post_remove_stock');

        CRUD::resource('movement', 'StockMovementCrudController');
    });
    
    Route::get('ajax/inventory-name-options', 'MovementCrudController@inventoryNameOptions');
    CRUD::resource('movement', 'MovementCrudController');

    Route::group(['prefix' => 'movement/{movement_id}', 'as' => 'movement.'], function()
    {
        Route::get('rollback', 'MovementCrudController@rollbackForm')->name('rollback.form');
        Route::patch('rollback', 'MovementCrudController@rollback')->name('rollback');
    });

    CRUD::resource('supplier', 'SupplierCrudController');

    // Orders
    Route::get('order/sync', 'OrderCrudController@sync')->name('orders.sync');
    CRUD::resource('order', 'OrderCrudController');
    Route::get('order/{order_id}', 'OrderCrudController@show')->name('order.show');
    Route::patch('order/{order_id}/cancel', 'OrderCrudController@cancel')->name('order.cancel');
    Route::patch('order/{order_id}/reopen', 'OrderCrudController@reopen')->name('order.reopen');
    Route::get('order/{order_id}/pack', 'OrderCrudController@packForm')->name('order.pack.form');
    Route::patch('order/{order_id}/pack', 'OrderCrudController@pack')->name('order.pack');
    Route::get('order/{order_id}/print-pick-list', 'OrderCrudController@printPickList')->name('order.print_pick_list');
    Route::get('order/{order_id}/print-receipt', 'OrderCrudController@printReceipt')->name('order.print_receipt');
    Route::get('order/{order_id}/print-delivery-receipt', 'OrderCrudController@printDeliveryReceipt')->name('order.print_delivery_receipt');
    Route::get('order/{order_id}/print-carrier-receipt', 'OrderCrudController@printCarrierReceipt')->name('order.print_carrier_receipt');
    Route::get('order/{order_id}/print-all', 'OrderCrudController@printAll')->name('order.print_all');
    Route::get('order/{order_id}/ship', 'OrderCrudController@shipForm')->name('order.ship.form');
    Route::patch('order/{order_id}/ship', 'OrderCrudController@ship')->name('order.ship');
    Route::get('order/{order_id}/reservations', 'OrderCrudController@getReservations')->name('order.get_reservations');
    Route::post('order/{order_id}/reservations/pick', 'OrderCrudController@pickReservations')->name('order.reservations.pick');
    Route::get('order/{order_id}/reservations/pack', 'OrderCrudController@getPackReservations')->name('order.reservations.get_pack');
    Route::post('order/{order_id}/reservations/pack', 'OrderCrudController@postPackReservations')->name('order.reservations.post_pack');
    Route::get('order/{order_id}/reservations/ship', 'OrderCrudController@getShipReservations')->name('order.reservations.get_ship');
    Route::post('order/{order_id}/reservations/ship', 'OrderCrudController@postShipReservations')->name('order.reservations.post_ship');
    Route::patch('order/{order_id}/reservations', 'OrderCrudController@updateReservations')->name('order.update_reservations');
    Route::patch('order/{order_id}/packages/{order_package_id}/deliver', 'OrderCrudController@deliverOrderPackage')->name('order.packages.deliver');
    Route::patch('order/{order_id}/carriers/{order_carrier_id}/deliver', 'OrderCrudController@deliverOrderCarrier')->name('order.deliver_order_carrier');
    // Route::patch('order/{order_id}', 'OrderCrudController@update')->name('order.update');
    
    // Purchase orders
    Route::get('purchase-order/{purchase_order_id}/print-order', 'PurchaseOrderCrudController@printOrder')->name('purchase_order.print-order');
    CRUD::resource('purchase-order', 'PurchaseOrderCrudController')->name('purchase_order');
    Route::group(['prefix' => 'purchase-order/{purchase_order_id}', 'as' => 'purchase_order.'], function()
    {
        CRUD::resource('receiving', 'PurchaseOrderReceivingCrudController');
    });

    CRUD::resource('receiving', 'ReceivingCrudController');
    
    Route::get('transfer-order/{id}/complete', 'TransferOrderCrudController@completeForm')->name('transfer_order.complete_form');
    Route::patch('transfer-order/{id}/complete', 'TransferOrderCrudController@complete')->name('transfer_order.complete');
    Route::get('transfer-order/{id}/print', 'TransferOrderCrudController@printTransferOrder')->name('transfer_order.print');
    CRUD::resource('transfer-order', 'TransferOrderCrudController');

    Route::group(['prefix' => 'ajax'], function() {
        Route::get('purchase-order-receivings-products', 'PurchaseOrderProductsController@ajaxIndex')
            ->name('purchase_order_products.index');
        Route::get('purchase-order-products/{id}', 'PurchaseOrderProductsController@ajaxShow')
            ->name('purchase_order_products.show');
    });

});