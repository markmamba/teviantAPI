<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderProductsController extends Controller
{
    public function index(Request $request)
    {
    	$id = $request->input('id');
        //$orders = Order::orderby('created_at', 'desc')->get();
        $orderproducts = OrderProduct::where('order_id',$id)
        				->with('order')
        				->get();
       	$orderproducts->each(function($orderproduct){
       		$orderproduct->total = $orderproduct->order->total;
       	});
        return response()->json($orderproducts, 200);

    }
}
