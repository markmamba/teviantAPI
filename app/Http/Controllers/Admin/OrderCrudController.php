<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use Auth;
use App\Http\Requests\PackOrderRequest;
use App\Http\Requests\ShipOrderRequest;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderCarrier;
use App\Models\OrderPackage;
use App\Models\OrderShipment;
use App\Models\OrderShippingAddress;
use App\Models\OrderStatus;
use App\Models\OrderBillingAddress;
use App\Models\OrderProduct;
use App\Models\OrderProductPicking;
use App\Models\OrderProductReservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// VALIDATION: change the requests to match your own file names if you need form validation
// use App\Http\Requests\OrderRequest as StoreRequest;
// use App\Http\Requests\OrderRequest as UpdateRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\CreateOrderPackageRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrderCrudController extends CrudController
{
    /**
     * Auto-set the order status to "Pick Listed"
     * @var boolean
     */
    private $auto_pick_list = true;

    /**
     * Auto-set the order status to Done after it was set to Delivered.
     * @var boolean
     */
    private $auto_done_after_delivered = true;

    public function __construct()
    {
        parent::__construct();

        $this->ecommerce_client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('ECOMMERCE_BASE_URI'),
            // You can set any number of default request options.
            // 'timeout'  => 2.0,
        ]);
    }

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
       
        $this->setPermissions();

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS
        
        $this->crud->addColumn([
            'label' => 'Order #',
            'name'  => 'common_id'
        ]);
        $this->crud->addColumn([
            'label' => 'Customer',
            'name'  => 'full_user_name'
        ]);
        $this->crud->addColumn([
            'label' => 'Products',
            'name'  => 'products_count'
        ]);
        $this->crud->addColumn([
            'label' => 'Price',
            'name'  => 'total'
        ]);
        $this->crud->addColumn([
            'label' => 'Date',
            'name'  => 'created_at'
        ]);
        $this->crud->addColumn([
           'label' => "Status",
           'name' => 'status',
           'type' => 'view',
           'view' => 'admin.orders.columns.status_view', // or path to blade file
        ]);

        // ------ CRUD BUTTONS
        
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');

        $this->crud->addButtonFromView('top', 'sync_orders', 'sync_orders', 'top');
        $this->crud->addButtonFromView('line', 'order_view', 'order_view', 'beginning');

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->with('status');
        $this->crud->with('products');
        $this->crud->orderBy('created_at', 'desc');
        
        // Status filter
        $order_status_options = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'))->toArray();
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status'
        ], $order_status_options, function ($value) { // if the filter is active
            $this->crud->addClause('whereHas', 'status', function ($query) use ($value) {
                $query->where('id', 'like', '%'.$value.'%');
            });
        });

        // Custom queries
        $this->applyCustomQueries();

        // Remove columns and filters according to current tab.
        if (isset(request()->tab) && request()->tab != 'all') {
            $this->crud->removeColumn('status');
            $this->crud->removeFilter('status');
            
            if ($this->crud->filters()->count() == 0) {
                $this->crud->disableFilters();
            }
        }
    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $orders_on_statuses_count = [
            'pending'      => Order::pending()->count(),
            'partial'      => Order::partial()->count(),
            'for_picking'  => Order::forPicking()->count(),
            'for_shipping' => Order::forShipping()->count(),
            'shipped'      => Order::shipped()->count(),
            'completed'    => Order::completed()->count(),
            'cancelled'    => Order::cancelled()->count(),
        ];

        $this->data['tab'] = request()->tab;

        $this->data['orders_on_statuses_count'] = $orders_on_statuses_count;
        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.orders.list', $this->data);
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

        $request = $this->handleStatusChange($request, $order, $this->auto_done_after_delivered);

        $order->update($request->all());

        \Alert::success('Status updated.')->flash();

        return redirect()->route('order.show', $id);
    }

    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        $crud = $this->crud;

        $order = Order::with(['status', 'products', 'carriers', 'reservations', 'packages'])->findOrFail($id);

        $order_status_options = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'));
        $auto_done_after_delivered = $this->auto_done_after_delivered;

        return view('admin.orders.show', compact('order', 'crud', 'order_status_options', 'auto_done_after_delivered'));
    }

    /**
     * Sync the orders with the ecommerce site via its API.
     * @return view
     */
    public function sync()
    {
        $this->crud->hasAccessOrFail('sync');

        DB::beginTransaction();

        // Before syncing orders, sync categories and products first.
        $exitCode = \Artisan::call('sync:all');

        try {
            $response = $this->ecommerce_client->get('api/orders');
            $orders = collect(json_decode($response->getBody()));
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();
            \Log::critical($e->getMessage());
            DB::rollBack();
            return back();
        }

        // Re-format the created_at attribute so we can sort it properly afterwards.
        $orders = $orders->map(function($order){
            $order->created_at = \Carbon\Carbon::parse($order->created_at)->toDateTimeString();
            return $order;
        })->sortBy('created_at');

        // Save each orders on the database.
        foreach ($orders as $order) {

            // Skip the order if it was already saved before.
            if (Order::where('common_id', $order->id)->first())
                continue;

            // Skip the order if it does not have any products
            if (count($order->products) == 0)
                continue;
            
            try {
                // Save the new order
                $new_order = new Order;
                $new_order->common_id = $order->id;
                $new_order->created_at = \Carbon\Carbon::parse($order->created_at);
                $new_order->shipping_address = $order->shipping_address;
                $new_order->billing_address = $order->billing_address;
                $new_order->save(['timestamps' => false]);
            } catch (\Exception $e) {
                \Alert::error($e->getMessage())->flash();
                \Log::critical($e->getMessage());
                DB::rollBack();
                return back();
            }

            // Save the new order's user
            // $order_user = new OrderUser;
            // $order_user->first_name

            // Save the order's carrier
            // $carrier = OrderCarrier::create(
            //     collect($order->carrier)
            //     ->merge(['order_id' => $new_order->id])
            //     ->toArray()
            // );

            // Save each order's products.
            foreach ($order->products as $product) {
                try {
                    $order_product             = new OrderProduct();
                    $order_product->product_id = Inventory::findBySku2($product->pivot->sku)->id;
                    $order_product->order_id   = $new_order->id;
                    $order_product->common_id  = $product->pivot->product_id;
                    $order_product->name       = $product->pivot->name;
                    $order_product->sku        = $product->pivot->sku;
                    $order_product->quantity   = $product->pivot->quantity;
                    $order_product->price      = isset($product->pivot->price_with_tax) ? $product->pivot->price_with_tax : $product->pivot->price;
                    $order_product->save();
                } catch (\Exception $e) {
                    \Alert::error('Server error occured. Please check logs.')->flash();
                    \Log::critical([$e->getMessage(), $product]);
                    DB::rollBack();
                    return back();
                }
            }

             // Handle product reservation
            $this->reserveOrder($new_order, $this->auto_pick_list);
        }
        
        DB::commit();
        
        \Alert::success('Synced orders.')->flash();
        
        return redirect()->route('crud.order.index');
    }

    public function cancel($id, $request = null)
    {
        $this->crud->hasAccessOrFail('cancel');

        $order = Order::find($id);

        DB::beginTransaction();
        
        // Put back stock to the stock they where taken from.
        foreach ($order->products as $order_product) {
            foreach ($order_product->reservations as $reservation) {
                foreach ($reservation->pickings as $picking) {
                    $picking->movement->rollback();
                }
                $reservation->pickings()->delete();
                $reservation->delete();
            }
        }

        // Delete order's shipment record.
        if (isset($order->shipment))
            $order->shipment->delete();

        // If this function was triggered from an HTTP submit form.
        if (!isset($request)) {
            $order->update(request()->all());

            DB::commit();

            \Alert::success('Successfully cancelled order #'.$order->common_id)->flash();

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
        $this->crud->hasAccessOrFail('reopen');

        $order = Order::findOrFail($id);

        // Delete order's shipment record.
        if (isset($order->shipment))
            $order->shipment->delete();

        // Delete previous reservations
        $order->reservations()->delete();

        // Reserve products again for the order.
        $this->reserveOrder($order, $this->auto_pick_list);

        if (!$this->auto_pick_list) {
            $pending_status = OrderStatus::where('name', 'pending')->first();
            $order->update(['status_id' => $pending_status->id]);
        }

        return redirect()->route('crud.order.show', $id);
    }

    public function shipForm($id)
    {
        $this->crud->hasAccessOrFail('ship');

        // $this->crud->hasAccessOrFail('show');
        
        $crud = $this->crud;
        $order = Order::findOrFail($id);
        $order_status_options = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'));

        return view('admin.orders.ship', compact('crud', 'order', 'order_status_options'));
    }

    public function ship(ShipOrderRequest $request, $id)
    {
        $this->crud->hasAccessOrFail('ship');

        $order = Order::findOrFail($id);

        DB::beginTransaction();

        $order->update($request->all());

        $order_carrier = OrderCarrier::create(
            collect(['order_id' => $id])
            ->merge($request->all())
            ->merge([
                'price' => 0,
            ])
            ->toArray()
        );

        // dd($order->reservations()->whereNotNull('picked_at')->whereNull('order_carrier_id')->get());

        // Associate the picked reservations on the new shipment.
        foreach($order->reservations()->whereNotNull('picked_at')->whereNull('order_carrier_id')->get() as $reservation) {
            $reservation->order_carrier_id = $order_carrier->id;
            $reservation->save();
        }

        if ($order->status->name != 'Partial') {
            $order->status_id = OrderStatus::where('name', 'Shipped')->first()->id;
            $order->save();
        }

        DB::commit();

        \Alert::success('Status updated.')->flash();

        return redirect()->route('order.show', $id);
    }

    /**
     * Show the pack form.
     * @return view
     */
    public function packForm(Request $request, $id)
    {
        $this->crud->hasAccessOrFail('pack');

        // $this->crud->hasAccessOrFail('resource.action');

        $this->crud->model = Order::findOrFail($id);
        $this->crud->route = route('order.pack', $this->crud->model->id);

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = 'Pack Order';

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'status_id',
            'type' => 'hidden',
            'value' => OrderStatus::where('name', 'Packed')->first()->id,
        ]);
        $this->crud->addField([
           'label'     => 'Packer',
           'type'      => 'select2',
           'name'      => 'packer_id',
           'entity'    => 'packer',
           'attribute' => 'name',
        ]);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.orders.pack', $this->data);
    }

    public function pack(PackOrderRequest $request, $id)
    {
        $this->crud->hasAccessOrFail('pack');

        // dd($request->all());
        $order = Order::findOrFail($id);
        $order->update(
            collect($request->all())
            ->merge([
                'packer_id' => isset(request()->packer_id) ? request()->packer_id : Auth::user()->id,
                'packed_at' => \Carbon\Carbon::now()
            ])
            ->toArray()
        );

        foreach ($order->reservations as $reservation) {
            $reservation->quantity_taken = $reservation->quantity_reserved;
            $reservation->picked_at      = \Carbon\Carbon::now();
            $reservation->picked_by      = Auth::user()->id;
            $reservation->save();

            try {
                // Create a picking record. For now, we'lll do 1-1.
                $picking = new OrderProductPicking;
                $picking->reservation_id  = $reservation->id;
                $picking->quantity_picked = $reservation->quantity_taken;
                $picking->picker_id       = isset($request->packer_id) ? $request->packer_id : Auth::user()->id;
                $picking->picked_at       = \Carbon\Carbon::now();
                
                $reservation->stock->take($picking->reservation->quantity_reserved, 'Picked for order #' . $order->id);

                $picking->movement_id     = $picking->reservation->order_product->product->stocks->first()->getLastMovement()->id;
                $picking->save();
            } catch (\Stevebauman\Inventory\Exceptions\NotEnoughStockException $e) {
                // This shouldn't happen, if so, something is wrong on the reservation.
                \Alert::error($e->getMessage())->flash();
                return back();
            }
        }

        \Alert::success('Status updated.')->flash();

        return redirect()->route('order.show', $order->id);
    }

    public function printPickList($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = Order::findOrFail($id);

        // return view('pdf.pick_list', compact('order'));

        $pdf = \PDF::loadView('pdf.pick_list', compact('order'));
        return $pdf->stream();
    }

    public function printReceipt($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = Order::findOrFail($id);

        $pdf = \PDF::loadView('pdf.receipt', compact('order'));
        return $pdf->stream();
    }

    public function printDeliveryReceipt($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = Order::findOrFail($id);

        $pdf = \PDF::loadView('pdf.delivery_receipt', compact('order'));
        return $pdf->stream();
    }

    public function printCarrierReceipt($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = Order::findOrFail($id);

        $pdf = \PDF::loadView('pdf.carrier_receipt', compact('order'));
        return $pdf->stream();
    }

    public function printAll($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = Order::findOrFail($id);

        $pdf = \PDF::loadView('pdf.all', compact('order'));
        return $pdf->stream();
    }

    public function getReservations($order_id)
    {
        $crud = $this->crud;
        $order = Order::with(['status', 'products', 'reservations'])->findOrFail($order_id);

        return view('admin.orders.reservations', compact('crud', 'order'));
    }

    /**
     * WIP
     * @param  string  $order_id
     * @param  Request $request
     * @return redirect()
     */
    public function pickReservations($order_id, Request $request)
    {
        // dd($request->all());
        $order = Order::find($order_id);

        DB::beginTransaction();

        try {
            foreach ($request->reservations as $reservation_item) {
                $reservation = OrderProductReservation::find($reservation_item['id']);
                
                if (isset($reservation_item['is_picked'])) {

                    // Update the reservation
                    $reservation->quantity_taken = $reservation->quantity_reserved;
                    $reservation->picked_at      = \Carbon\Carbon::now();
                    $reservation->picked_by      = Auth::user()->id;
                    $reservation->save();

                    // Create a picking record. For now, we'lll do 1-1.
                    $picking = new OrderProductPicking;
                    $picking->reservation_id  = $reservation->id;
                    $picking->quantity_picked = $reservation->quantity_taken;
                    $picking->picker_id       = isset($request->packer_id) ? $request->packer_id : Auth::user()->id;
                    $picking->picked_at       = \Carbon\Carbon::now();
                    
                    $reservation->stock->take($picking->reservation->quantity_reserved, 'Picked for order #' . $order->id);

                    $picking->movement_id     = $picking->reservation->order_product->product->stocks->first()->getLastMovement()->id;
                    $picking->save();

                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::critical('Could not pick product reservations.', [$e->getMessage()]);
            throw new \Exception($e->getMessage());
        }

        DB::commit();

        \Alert::success('Successfully picked reservations.')->flash();

        return redirect()->route('order.show', $order->id);
    }

    /**
     * Show the view for for packing the picked reservations.
     * @return view()
     */
    public function getPackReservations($order_id)
    {
        $crud = $this->crud;
        $order = Order::with(['status', 'products', 'products.reservations'])->findOrFail($order_id);

        // Check if the order does not have packable reservations.
        if (!$order->hasPackableReservations()) {
            \Alert::warning('The order does not have products to be packed. Check if there are reservations and pick them first.')->flash();
            return redirect()->route('order.show', $order->id);
        }

        return view('admin.orders.reservations_pack', compact('crud', 'order'));
    }

    public function postPackReservations($order_id, CreateOrderPackageRequest $request)
    {
        // dd($request->all());

        $order = Order::find($order_id);

        DB::beginTransaction();

        try {
            foreach ($request->reservations as $reservation_item) {
                $reservation = OrderProductReservation::find($reservation_item['id']);
                
                if (isset($reservation_item['is_picked'])) {
                    // Update the reservation as packed
                    $reservation->packed_at = \Carbon\Carbon::now();
                    $reservation->packed_by = Auth::user()->id;
                }

                $order_carrier = OrderCarrier::create(
                    collect(['order_id' => $order_id])
                    ->merge($request->all())
                    ->merge([
                        'price' => 0,
                        'name' => 'LBC'
                    ])
                    ->toArray()
                );

                // Create a package record
                $order_package = OrderPackage::create([
                    'order_id'             => $order->id,
                    'sales_invoice_number' => $request->sales_invoice_number,
                    'tracking_number'      => $request->tracking_number,
                    'order_carrier_id'     => $order_carrier->id,
                ]);

                // Associate the reservation to the new package.
                $reservation->order_package_id = $order_package->id;

                $reservation->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::critical('Could not pack product reservations. Check error logs.', [$e->getMessage()]);
            throw new \Exception($e->getMessage());
        }

        DB::commit();
        \Alert::success('Successfully packed order reservations.')->flash();
        return redirect()->route('order.show', $order->id);
    }

    /**
     * Show the view for for packing the picked reservations.
     * @return view()
     */
    public function getShipOrderPackage($order_id, $order_package_id)
    {
        $crud = $this->crud;
        $order = Order::with(['status', 'products', 'products.reservations'])->findOrFail($order_id);
        $order_package = $order->packages()->findOrFail($order_package_id);

        // Check if the order does not have packable reservations.
        if (!$order->hasShippableReservations()) {
            \Alert::warning('The order does not have products to be shipped. Check if there are reservations and pack them first.')->flash();
            return redirect()->route('order.show', $order->id);
        }

        return view('admin.orders.packages_ship', compact('crud', 'order', 'order_package'));
    }

    public function postShipOrderPackage($order_id, Request $request)
    {
        // dd($request->all());
        // $this->crud->hasAccessOrFail('ship');

        $order = Order::findOrFail($order_id);

        DB::beginTransaction();

        $order->update($request->all());

        // dd($order->reservations()->whereNotNull('picked_at')->whereNull('order_carrier_id')->get());

        // Associate the picked reservations on the new shipment.
        foreach($order->packages()->whereNull('shipped_at')->get() as $package) {
            $package->shipped_at = Carbon::now();
            $package->save();
        }

        if ($order->status->name != 'Partial') {
            $order->status_id = OrderStatus::where('name', 'Shipped')->first()->id;
            $order->save();
        }

        DB::commit();

        \Alert::success('Package shipped.')->flash();

        return redirect()->route('order.show', $order->id);
    }

    public function handleStatusChange($request, $order, $auto_complete = true)
    {
        // Automatically complete an order if it was set to delivered.
        if ($auto_complete)
            if (OrderStatus::find($request->status_id)->name === 'Delivered')
                $request->merge([
                    'status_id' => OrderStatus::where('name', 'Done')->first()->id
                ]);

        $this->handleCancellation($request, $order);
        // $this->handlePicking($request, $order);
        
        return $request;
    }

    public function deliverOrderCarrier($order_id, $order_carrier_id)
    {
        try {
            DB::beginTransaction();

            $order_carrier = OrderCarrier::find($order_carrier_id);
            $order_carrier->update([
                'delivered_at' => Carbon::now()
            ]);

            // Check if all products have been delivered
            if ($order_carrier->order->isSufficient()) {
                $order_carrier->order->status_id = OrderStatus::where('name', 'Delivered')->first()->id;
                $order_carrier->order->save();
            }

            DB::commit();

            return redirect()->route('order.show', $order_carrier->order->id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }

    public function deliverOrderPackage($order_id, $order_package_id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $order_package = OrderPackage::find($order_package_id);
            $order_package->update([
                'delivered_at' => Carbon::now()
            ]);

            // Check if all products have been delivered
            if ($order_package->order->isSufficient()) {
                $order_package->order->status_id = OrderStatus::where('name', 'Delivered')->first()->id;
                $order_package->order->save();
            }

            DB::commit();

            \Alert::success('Package set as delivered.')->flash();

            return redirect()->route('order.show', $order_package->order->id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }


    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'show', 'update', 'delete', 'sync', 'reopen', 'pack', 'ship', 'cancel']);

        // Allow list access
        if ($user->can('orders.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('orders.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow show access
        if ($user->can('orders.show')) {
            $this->crud->allowAccess('show');
        }

        // Allow update access
        if ($user->can('orders.update')) {
            $this->crud->allowAccess('update');
        }

        // Allow sync access
        if ($user->can('orders.sync')) {
            $this->crud->allowAccess('sync');
        }

        // Allow reopen access
        if ($user->can('orders.reopen')) {
            $this->crud->allowAccess('reopen');
        }

        // Allow pack access
        if ($user->can('orders.pack')) {
            $this->crud->allowAccess('pack');
        }

        // Allow ship access
        if ($user->can('orders.ship')) {
            $this->crud->allowAccess('ship');
        }

        // Allow cancel access
        if ($user->can('orders.cancel')) {
            $this->crud->allowAccess('cancel');
        }
    }

    private function handleCancellation($request, $order)
    {
        $cancelled_status = OrderStatus::where('name', 'cancelled')->first();
        $done_status = OrderStatus::where('name', 'done')->first();
        
        if ($request->status_id == $cancelled_status->id) {
            
            $this->cancel($order->id, $request);
            
            // Afterwards, change the status_id to the Id of the Done status
            // because the Ecommerce app does not have a cancelled status yet.
            $request->status_id = $done_status->id;
        }

        return $request;
    }

    /**
     * Reserve a given order's products.
     * @param  App\Models\Order  $order The model instance or the id of the model
     * @param  App\Models\Order  $order
     * @param  boolean $auto_pick_list Auto-set the status of the order to "Pick Listed"
     * if the order has reserved enough stocks.
     * @return Collection of App\Models\OrderProductReservation
     */
    private function reserveOrder($order, $auto_pick_list = false)
    {
        foreach ($order->products as $product) {
            $reservations = $this->reserveProduct($product);
        }

        // If the order can be fully fulfilled.
        if ($auto_pick_list && $order->isSufficient()) {
            $order->status_id = OrderStatus::where('name', 'Pick Listed')->first()->id;
            $order->save();
        }

        // If the order can be partially fulfilled
        if ($auto_pick_list && $order->isPartiallyFulfillable())
        {
            $order->status_id = OrderStatus::where('name', 'Partial')->first()->id;
            $order->save();
        }

        return $order->reservations;
    }

    /**
     * Reserve and or take available stock from the inventory.
     * @return  Collection of App\Models\OrderProductReservation
     */
    private function reserveProduct(OrderProduct $order_product)
    {
        // Get items' stocks from all locations order by stock with most stock.
        $item = Inventory::findBySku2($order_product->sku);
        $stocks = $item->stocks()->orderBy('quantity', 'desc')->get();
        
        if (!$item->isInStock($order_product->quantity)) {
            // TODO: Record this deficiency so the admins know what to replenish
        }

        // Check if we can reserve enough stock from the most abundant location.
        if ($stocks->first()->hasEnoughStockForReservation($order_product->quantity)) {
            // Reserve the available stock.
            // $stocks->first()->take($order_product->quantity);

            // Save the product's reservation.
            $reservation                    = new OrderProductReservation();
            $reservation->order_product_id  = $order_product->id;
            $reservation->user_id           = Auth::user()->id;
            $reservation->stock_id          = $stocks->first()->id;
            $reservation->quantity_reserved += $order_product->quantity;
            $reservation->save();

            // // tmp debug
            // echo '<hr>';
            // echo 'Stock #: '.$stocks->first()->id;
            // echo '<br>';
            // echo 'Order quantity: '.$order_product->quantity;
            // echo '<br>';
            // echo 'Stock quantity: '.$stocks->first()->quantity;
            // echo '<br>';
            // echo 'Reservable: '.$stocks->first()->quantityReservable();
            // echo '<br>';
            // echo 'Total reserved: '.$order_product->quantity_reserved;
            // echo '<br>';
            // echo 'Reserved: '.$reservation->quantity_reserved;
            // echo '<br>';
            // echo 'Fully reserved?: '.$order_product->isFullyReserved();
        } else {
            
            // // tmp debug
            // echo '<br>';
            // echo 'Order #: '.$order_product->order->id;

            foreach ($stocks as $key => $stock) {
                
                if ($stock->hasEnoughStockForReservation() && !$order_product->isFullyReserved()) {

                    // // tmp debug
                    // echo '<hr>';
                    // echo 'Stock #: '.$stock->id;
                    // echo '<br>';
                    // echo 'Order quantity: '.$order_product->quantity;
                    // echo '<br>';
                    // echo 'Stock quantity: '.$stock->quantity;
                    // echo '<br>';
                    // echo 'Reservable: '.$stock->quantityReservable();
                    // echo '<br>';
                    // echo 'Total reserved: '.$order_product->quantity_reserved;

                    // Formula: (order - (order - stock)) - reserved
                    // $stock_quantity_takable = ($order_product->quantity - ($order_product->quantity - $stock->quantity)) - $order_product->quantity_reserved;
                    // $stock->take($stock_quantity_takable);

                    $formula_result = $order_product->quantity - ($order_product->quantity - $stock->quantityReservable()) - $order_product->quantity_reserved;
                    // if ($formula_result <= 0) {
                    if ($formula_result <= $order_product->quantity && $formula_result >= 0) {
                        $stock_quantity_reservable = $order_product->quantity - ($order_product->quantity - $stock->quantityReservable()) - $order_product->quantity_reserved;
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Reservable formula: '. $order_product->quantity .'-('.$order_product->quantity .'-'. $stock->quantityReservable().')-'. $order_product->quantity_reserved;
                    }
                    else {
                        $stock_quantity_reservable = $order_product->quantity - $order_product->quantity_reserved;
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Reservable formula used: '. $order_product->quantity .'-'. $order_product->quantity_reserved;
                    }

                    // // tmp
                    // echo '<br>';
                    // echo '$stock_quantity_reservable: '.$stock_quantity_reservable;

                    try {
                        // Save the product's reservation.
                        $reservation                    = new OrderProductReservation();
                        $reservation->order_product_id  = $order_product->id;
                        $reservation->user_id           = Auth::user()->id;
                        $reservation->stock_id          = $stock->id;
                        $reservation->quantity_reserved += $stock_quantity_reservable;
                        $reservation->save();
                    } catch (\Exception $e) {
                        abort(500, $e->getMessage());
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Error on iteration: '.$key;
                    }

                    // // tmp debug
                    // echo '<br>';
                    // echo 'Reserved: '.$reservation->quantity_reserved;
                    // echo '<br>';
                    // echo 'Fully reserved?: '.$order_product->isFullyReserved();
                } else {
                    break;
                }
            }
        }

        return $order_product->reservations();
    }

    /**
     * Apply custom queries here.
     * @return void
     */
    private function applyCustomQueries()
    {
        // Filter status based on tab
        $tab = request()->tab;

        if (!in_array($tab, ['pending', 'partial', 'for_picking', 'for_shipping', 'shipped', 'completed', 'cancelled']))
            return redirect()->route('crud.order.index');
        
        if (isset($tab)) {
            if ($tab == 'pending')
                $this->crud->addClause('pending');
            if ($tab == 'partial')
                $this->crud->addClause('partial');
            if ($tab == 'for_picking')
                $this->crud->addClause('forPicking');
            if ($tab == 'for_shipping')
                $this->crud->addClause('forShipping');
            if ($tab == 'shipped')
                $this->crud->addClause('shipped');
            if ($tab == 'completed')
                $this->crud->addClause('completed');
            if ($tab == 'cancelled')
                $this->crud->addClause('cancelled');
        }
    }
}
