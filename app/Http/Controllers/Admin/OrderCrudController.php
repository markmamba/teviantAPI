<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\OrderBillingAddress;
use App\Models\OrderProduct;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OrderRequest as StoreRequest;
use App\Http\Requests\OrderRequest as UpdateRequest;
use GuzzleHttp\Client;

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

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);
        
        // $this->crud->addColumn([
        //    // 1-n relationship
        //    'label'     => 'Order', // Table column heading
        //    'type'      => 'select',
        //    'name'      => 'order_id', // the column that contains the ID of that connected entity;
        //    'entity'    => 'order', // the method that defines the relationship in your Model
        //    'attribute' => 'products_count', // foreign key attribute that is shown to user
        //    'tab'       => 'Primary',
        // ]);

        $this->crud->removeColumn('common_id');
        $this->crud->addColumn([
            'label' => 'User',
            'name'  => 'full_user_name'
        ]);
        $this->crud->addColumn([
            'label' => 'Shipping Address',
            'name'  => 'full_shipping_address'
        ]);
        $this->crud->addColumn([
            'label' => 'Billing Address',
            'name'  => 'full_billing_address'
        ]);
        $this->crud->addColumn([
            'label' => 'Total',
            'name'  => 'total'
        ]);
        $this->crud->addColumn([
            'label' => 'Created At',
            'name'  => 'created_at'
        ]);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');
        
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');

        $this->crud->addButtonFromView('top', 'sync_orders', 'sync_orders', 'top');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
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

    // public function index()
    // {
    //     $this->crud->hasAccessOrFail('list');
 
    //     $this->data['crud'] = $this->crud;
    //     $this->data['title'] = ucfirst($this->crud->entity_name_plural);
 
    //     // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
    //     return view($this->crud->getListView(), $this->data);
    // }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

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

                $order_product->product_id = Inventory::first()->id;
                $order_product->order_id   = $new_order->id;
                $order_product->common_id  = $product->product_id;
                $order_product->name       = $product->name;
                $order_product->sku        = $product->sku;
                $order_product->quantity   = $product->quantity;
                $order_product->price      = $product->price_with_tax;
                $order_product->save();
            }
        }

        // dd($orders);
        
        \Alert::success('Synced orders.')->flash();
        
        return redirect()->route('crud.order.index');
    }
}
