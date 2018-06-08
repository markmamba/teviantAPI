<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\PurchaseOrderReceiving;
use App\Models\PurchaseOrderReceivingProduct;
use App\Http\Requests\ReceivingRequest as StoreRequest;
use App\Http\Requests\ReceivingRequest as UpdateRequest;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;

class PurchaseOrderReceivingCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel('App\Models\PurchaseOrderReceiving');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/receiving');
        $this->crud->setEntityNameStrings('Receiving', 'Purchase Orders');
        
        // Nested pruchase order receiving
        $purchase_order_id = \Route::current()->parameter('purchase_order_id');
        $this->crud->setRoute(route('purchase_order.crud.receiving.index', $purchase_order_id));
        $this->purchase_order = PurchaseOrder::findOrFail($purchase_order_id);

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */

        // ------ CRUD FIELDS
        // $this->crud->child_resource_included = ['select' => false, 'number' => false];
        $this->crud->addFields([
            // TODO: merge Product order number and products fields into single custom field.
            [
                'label'     => 'Purchase Order #',
                'type'      => 'select2_from_array',
                'name'      => 'purchase_order_id',
                'entity'    => 'purchase_order',
                'attribute' => 'id',
                'options' => [
                    $this->purchase_order->id => $this->purchase_order->id
                ],
                'default'   => $purchase_order_id,
                'model'     => 'App\Models\PurchaseOrder',
                'tab'       => 'Primary',
            ],
            [
                'label'        => 'Products',
                'name'         => 'products_json',
                'type'         => 'table_prefill_purchase_order_products',
                'entity'       => 'product',
                'attribute'    => 'id',
                'parent_model' => 'App\Models\PurchaseOrder',
                'tab'          => 'Primary',
                'columns'      => [
                    'sku'      => 'SKU',
                    'name'     => 'Name',
                    'quantity' => 'Quantity',
                ],
            ],
            [
                'label'     => 'Receiver',
                'type'      => 'select2',
                'name'      => 'receiver_id',
                'entity'    => 'receiver',
                'attribute' => 'name',
                'tab'       => 'Primary',
            ],
            [
                'label' => 'Remark',
                'name'  => 'remark',
                'type'  => 'text',
                'tab'   => 'Optionals',
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns([
            [
                'label' => 'Receiving #',
                'name' => 'id',
                'type' => 'text',
            ],
            [
                'label'     => 'Purchase Order #',
                'type'      => 'select',
                'name'      => 'purchase_order_id',
                'entity'    => 'purchase_order',
                'attribute' => 'id',
           ],
           [
                'label'     => 'Receiver',
                'type'      => 'select',
                'name'      => 'receiver_id',
                'entity'    => 'receiver',
                'attribute' => 'name',
           ],
           [
                'label'     => 'Remark',
                'type'      => 'text',
                'name'      => 'remark',
           ],
           [
                'label'     => 'Date Received',
                'type'      => 'text',
                'name'      => 'created_at',
           ],
        ]);

        // ------ CRUD BUTTONS
        
        // Custom View button instead of Preview for consistency among previosly added list views.
        $this->crud->addButtonFromView('line', 'purchase_order_receiving_view', 'purchase_order_receiving_view', 'beginning');
        $this->crud->removeButton('preview');

        // ------ CRUD ACCESS
        $this->setPermissions();

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        
        // For the nested resource
        $this->crud->addClause('where', 'purchase_order_id', '=', $purchase_order_id);

        $this->crud->orderBy('created_at', 'desc');
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');
        
        $this->crud->setCreateView('admin.purchase_orders.receivings.create');

        // Check if the Purchase Order is already complete.
        if ($this->purchase_order->isCompleted()) {
            \Alert::warning('The Purchase Order is already completed.')->flash();
            return back();
        }

        return parent::create();
    }

    public function store(StoreRequest $request)
    {
        // dd($request->all());
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);

        $receiving = $purchase_order->receivings()->create(
            collect($request->only(['purchase_order_id', 'remark']))
            ->merge(['receiver_id' => \Auth::user()->id])
            ->toArray()
        );

        $products = collect(json_decode($request->products_json))->where('quantity', '!=', null);

        // Validate product receivings
        $errors = collect([]);

        if ($products->count()) {
            foreach ($products as $product) {
                $purchase_order_product = PurchaseOrderProduct::findOrFail($product->id);
                if (!isset($product->quantity)) {
                    $errors->push('The quantity for '.$purchase_order_product->inventory->sku_code.' is invalid.');
                } else if (!($product->quantity > 0) || !($product->quantity <= $purchase_order_product->quantity_pending)) {
                    $errors->push('The quantity for '.$purchase_order_product->inventory->sku_code.' must be between 1 and '.$purchase_order_product->quantity_pending);
                }
            }
        } else {
            $errors->push('There must be at least 1 product to receive.');
        }

        if ($errors->count())
            return back()->withErrors($errors);

        // Store the product receivings
        foreach ($products as $product) {            
            $receiving->products()->create(
                collect($request->only(['purchase_order_receiving_id']))
                ->merge([
                    'purchase_order_product_id' => $product->id,
                    'quantity' => $product->quantity,
                    'receiver_id' => \Auth::user()->id
                ])
                ->toArray()
            );

            // Save completion date for the Purchase Order Product if completed.
            $purchase_order_product = PurchaseOrderProduct::find($product->id);
            if ($purchase_order_product->is_completed)
                $purchase_order_product->update(['completed_at' => \Carbon\Carbon::now()]);
        }
        
        return redirect()->route('crud.purchase-order.index');
    }

    public function update(UpdateRequest $request, $receiving_id)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        $receiving = PurchaseOrderReceiving::findOrFail($receiving_id);
        $products = json_decode($request->products_json);

        foreach ($products as $product) {

            // TODO: validate receiving
            
            PurchaseOrderReceivingProduct::findOrFail($product->id)->update([
                'quantity' => $product->quantity,
            ]);
        }
        
        return redirect()->route('crud.receiving.index');
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('receivings.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('receivings.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow show access
        if ($user->can('receivings.show')) {
            $this->crud->allowAccess('show');
        }
    }
}
