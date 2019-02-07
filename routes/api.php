<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => ['client'], 'as' => 'api.'], function() {

	// test route
	Route::get('test', function (Request $request) {
    	return 'Welcome to our API!';
	});

	Route::apiResource('categories', 'CategoriesController');
	Route::apiResource('products', 'ProductsController');
	//Route::apiResource('orders', 'OrdersController');

});



	Route::post('user/login','Api\UserController@login');

	Route::group(['prefix'=>'user', 'middleware' => 'auth:api'], function(){
		Route::get('logout', 'Api\UserController@logout');
		Route::get('/', 'Api\UserController@getUser');
	});


	
	

	Route::group(['prefix'=>'orders'], function(){
		Route::get('statuses', 'Api\OrdersController@countPerStatus');
		//Route::get('statuses/{status}', 'Api\OrdersController@showStatus');
		//Route::get('statuses/{status}/{common_id}', 'Api\OrdersController@showStatusInfo');
		Route::get('statuses/{status}', 'Api\OrdersController@filter');
		Route::get('orderProducts','Api\OrderProductsController@index');
		Route::get('/{order_id}','Api\OrdersController@filterAll');
		Route::patch('statuses/{status}/{common_id}', 'Api\OrdersController@update');
		Route::apiResource('/', 'Api\OrdersController');
		//products
	});

	



	





Route::get('test', function (Request $request) {
    return 'Welcome to our API!';
})->middleware('client');
