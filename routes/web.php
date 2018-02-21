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

});