<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\OrderStatus;
use App\Models\OrderBillingAddress;
use App\Models\OrderProduct;

// VALIDATION: change the requests to match your own file names if you need form validation
// use App\Http\Requests\OrderRequest as StoreRequest;
// use App\Http\Requests\OrderRequest as UpdateRequest;
use App\Http\Requests\UpdateOrderRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrderCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('order', 'orders');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS
        
        $this->crud->addColumn([
            'label' => 'Id',
            'name'  => 'common_id'
        ]);
        $this->crud->addColumn([
            'label' => 'Customer',
            'name'  => 'full_user_name'
        ]);
        $this->crud->addColumn([
            'label' => 'Total',
            'name'  => 'total'
        ]);
        $this->crud->addColumn([
           'label'     => 'Status',
           'type'      => 'select',
           'name'      => 'status_id',
           'entity'    => 'status',
           'attribute' => 'name',
        ]);
        $this->crud->addColumn([
            'label' => 'Created At',
            'name'  => 'created_at'
        ]);

        // ------ CRUD BUTTONS
        
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');

        $this->crud->addButtonFromView('top', 'sync_orders', 'sync_orders', 'top');
        $this->crud->addButtonFromView('line', 'order_view', 'order_view', 'beginning');

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
    }

    public function __construct()
    {
        parent::__construct();

        $this->ecommerce_client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('ECOMMERCE_BASE_URI'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateOrderRequest $request, $id)
    {   
        $order = Order::findOrFail($id);

        // Handle cancellation if so.
        $request = $this->handleCancellation($request, $id);

        $order->update($request->all());

        \Alert::success('Status updated.')->flash();

        return redirect()->route('order.show', $id);
    }

    public function show($id)
    {
        // $this->crud->hasAccessOrFail('show');

        $crud = $this->crud;

        $order = Order::findOrFail($id);
        $order_status_options = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'));

        return view('admin.orders.show', compact('order', 'crud', 'order_status_options'));
    }

    /**
     * Sync the orders with the ecommerce site via its API.
     * @return view
     */
    public function sync()
    {
        $response = $this->ecommerce_client->get('api/orders');
        
        $orders = json_decode($response->getBody());

        // Save each orders on the database.
        foreach ($orders as $order) {

            // Skip the order if it is already saved before.
            if (Order::where('common_id', $order->id)->first())
                continue;
            
            // Save the new order
            $new_order = new Order;
            $new_order->common_id = $order->id;
            $new_order->save();

            // Save the new order's user
            // $order_user = new OrderUser;
            // $order_user->first_name

            // Save the new order's shipping address
            $shipping_address               = new OrderShippingAddress;
            $shipping_address->common_id    = $order->shipping_address->id;
            $shipping_address->order_id     = $new_order->id;
            $shipping_address->name         = $order->shipping_address->name;
            $shipping_address->address1     = $order->shipping_address->address1;
            $shipping_address->address2     = $order->shipping_address->address2;
            $shipping_address->county       = $order->shipping_address->county;
            $shipping_address->city         = $order->shipping_address->city;
            $shipping_address->postal_code  = $order->shipping_address->postal_code;
            $shipping_address->phone        = $order->shipping_address->phone;
            $shipping_address->mobile_phone = $order->shipping_address->mobile_phone;
            $shipping_address->save();

            // Save the new order's billing address
            $billing_address               = new OrderBillingAddress;
            $billing_address->common_id    = $order->billing_address->id;
            $billing_address->order_id     = $new_order->id;
            $billing_address->name         = $order->billing_address->name;
            $billing_address->address1     = $order->billing_address->address1;
            $billing_address->address2     = $order->billing_address->address2;
            $billing_address->county       = $order->billing_address->county;
            $billing_address->city         = $order->billing_address->city;
            $billing_address->postal_code  = $order->billing_address->postal_code;
            $billing_address->phone        = $order->billing_address->phone;
            $billing_address->mobile_phone = $order->billing_address->mobile_phone;
            $billing_address->save();

            // Save each order's products.
            foreach ($order->products as $product) {
                $order_product             = new OrderProduct();
                
                /**
                 * ISSUE: The following code is basically Inventory::findBySku($sku)
                 * but the library is having some issue, so we'll do it manually here.
                 * @var string
                 */
                $order_product->product_id = Inventory::whereHas('sku', function ($query) use ($product) {
                    $query->select('id', 'code');
                    $query->where('code', $product->sku);
                })->first()->id;

                $order_product->product_id = Inventory::findBySku2($product->sku)->id;
                $order_product->order_id   = $new_order->id;
                $order_product->common_id  = $product->product_id;
                $order_product->name       = $product->name;
                $order_product->sku        = $product->sku;
                $order_product->quantity   = $product->quantity;
                $order_product->price      = isset($product->price_with_tax) ? $product->price_with_tax : $product->price;
                $order_product->save();

                // handle product reservation
                $this->reserveProduct($order_product);
            }
        }

        // dd($orders);
        
        \Alert::success('Synced orders.')->flash();
        
        return redirect()->route('crud.order.index');
    }

    public function cancel($id, $request = null)
    {
        $order = Order::find($id);

        // TODO: Put back each order items' stock to where they were taken.
        // TODO: use rollbacks.
        // For now lets put them back to any stock.
        foreach ($order->products as $order_product) {
            $stock = $order_product->product->stocks()->orderBy('quantity', 'desc')->first();
            // dd($stock, $order_product->product, $order_product->product->stocks, $order_product->quantity_reserved);
            $stock->add($order_product->quantity_reserved, 'Cancelled');
            $order_product->quantity_reserved = 0;
            $order_product->save();
        }

        if (!isset($request)) {
            $order->update(request()->all());

            return redirect()->route('crud.order.show', $id);
        }
    }

    /**
     * Reopen a given order.
     * @param  Request $request
     * @return view
     */
    public function reopen(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Reserve products again for the order.
        foreach ($order->products as $product) {
            $this->reserveProduct($product);
        }

        $pending_status = OrderStatus::where('name', 'pending')->first();
        $order->update(['status_id' => $pending_status->id]);

        return redirect()->route('crud.order.show', $id);
    }

    private function handleCancellation($request, $id)
    {
        $cancelled_status = OrderStatus::where('name', 'cancelled')->first();
        $done_status = OrderStatus::where('name', 'done')->first();
        
        if ($request->status_id == $cancelled_status->id) {
            
            $this->cancel($id, $request);
            
            // Afterwards, change the status_id to the Id of the Done status
            // because the Ecommerce app does not have a cancelled status yet.
            $request->status_id = $done_status->id;
        }

        return $request;
    }

    /**
     * Reserve and or take available stock from the inventory.
     * @param  Inventory $inventory
     */
    private function reserveProduct(OrderProduct $order_product)
    {
        // Get items' stocks from all locations order by stock with most stock.
        $item = Inventory::findBySku2($order_product->sku);
        $stocks = $item->stocks()->orderBy('quantity', 'desc')->get();

        // dd($item, $stocks);
        
        if (!$item->isInStock($order_product->quantity)) {
            // Record this deficiency so the admins know what to replenish
        }
        
        // Check if we can reserve enough stock from the most abundant location.
        if ($stocks->first()->hasEnoughStock($order_product->quantity)) {
            // Reserve the available stock.
            $stocks->first()->take($order_product->quantity);
            $order_product->quantity_reserved += $order_product->quantity;
            $order_product->save();
        } else {
            // Take what's available from each stock location until we reserve the ordered quantity.
            // TODO: record reservations on another table for better tracking (order_product_reservations)
            foreach ($stocks as $stock) {
                if ($item->isInStock()) {
                    // Formula: (order - (order - stock)) - reserved
                    $stock->take(($order_product->quantity - ($order_product->quantity - $stock->quantity)) - $order_product->quantity_reserved);
                } else {
                    continue;
                }
            }
        }
    }
}
