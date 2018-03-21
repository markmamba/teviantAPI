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
        Route::post('rollback', 'MovementCrudController@rollback')->name('rollback');
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
    Route::get('order/{order_id}/ship', 'OrderCrudController@ship')->name('order.ship');
    // Route::patch('order/{order_id}', 'OrderCrudController@update')->name('order.update');

});