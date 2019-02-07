<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*public function index(Request $request)
    {
        $orders = Order::orderby('status_id', 'desc')->get();
        return response()->json($orders, 200);

    }*/

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        if(is_null($search)){
            $orders = Order::orderby('status_id', 'desc')->get();
            $orders->each(function($order){
                $order->total = $order->total;
            });

            return response()->json($orders, 200);
        }else{
            $orders = Order::whereHas('status', function ($query) use ($search){
               $query->where('name', $search);
            })
            // ->orWhereRaw('MONTH(created_at) = ?',date('m', strtotime($search)))
            ->orWhere('common_id', $search)
            //->orWhere('id', $search)
            ->orWhereJsonContains('shipping_address->name', $search)
            ->get();
            return response()->json($orders);

        }

        

    }

    public function filterAll($id){
        $orders = Order::where('id',$id)->get();

        return response()->json($orders);
    }

    public function filter(Request $request,$status){

        $search = $request->input('search');

        if(is_null($search)){
            $orders = Order::whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            })
            ->get();
        
        return response()->json($orders);
        }else{
            //dd($status);
            $orders = Order::whereHas('status', function ($query) use ($status) {
                //dd($status);
                $query->where('name', $status);

            })
            //->whereRaw('MONTH(created_at) = ?',date('m', strtotime($search)))
            ->Where('common_id', $search)
            ->orWhere('id', $search)
            ->orWhereJsonContains('shipping_address->name', $search)
            ->get();
            return response()->json($orders);
        
        }

        
        
    
    }

    /*public function filter(Request $request, $status){

        $common_id = $request->input('common_id');

        $orders = Order::whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            })
            ->where('common_id', $common_id)
            ->first();
        
        return response()->json($orders);
    }*/

    /*public function showStatus(Request $request, $status)
    {
        $orders = Order::whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            })
            ->get();
        
        return response()->json($orders);
    }



    public function showStatusInfo($status, $id)
    {
        $orders = Order::whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            })
                        ->where('common_id',$id)
            ->get();

            if(!$orders->isEmpty()){
                return response()->json($orders);
            }else{
                return response()->json(['No order found'], 404);
            }
        
        
    }*/


    public function countPerStatus()
    {
        //$orders = Order::orderby('created_at', 'desc')->get();
        //$orders = Order::orderby('status_id', 'desc')->get();


        //return response()->json($orders);

        $order_by_status = [
            'pending'      => Order::pending()->count(),
            'for_picking'  => Order::forPicking()->count(),
            'for_shipping' => Order::forShipping()->count(),
            'shipped'      => Order::shipped()->count(),
            'completed'    => Order::completed()->count(),
            'cancelled'    => Order::cancelled()->count(),
        ];
        //$picking = ['for_picking'  => Order::forPicking()->count()];
        //$shipping = ['for_shipping' => Order::forShipping()->count()];


        return response()->json([$order_by_status]);

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return json_encode($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Order::where('id', $id)->get();


        return response()->json($orders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$status, $id)
    {
        try {
            $check_id = Order::whereHas('status', function ($query) use ($status) {
                            $query->where('name', $status);
                            })
                            ->where('common_id',$id)
                            ->get();

            $order_id = Order::where('common_id', $id)
                            ->first();

            $order_status = $request->input('status_id');
            //$order_packer_id = $request->input('packer_id');
            $order_packed_at = Carbon::now()->toDateTimeString();
            
            if (!$check_id->isEmpty()) {

                $values = array(
                    'status_id' => $order_status,
                    //'packer_id' => $order_packer_id,
                    'packed_at' => $order_packed_at,
                    
                );
                    Order::where('common_id', $id)
                        ->update(['status_id' => $order_status, 'packed_at' => $order_packed_at]);
                        return response()->json([$values], 200);
                    //return $this->success_message('successfully_updated', $values, 200);    
                // }
            } else {
                return response()->json(['order does not exist'], 404);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
