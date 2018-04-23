<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderReceiving;
use App\Models\PurchaseOrderReceivingProduct;
use App\Http\Requests\ReceivingRequest as StoreRequest;
use App\Http\Requests\ReceivingRequest as UpdateRequest;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;

class ReceivingCrudController extends CrudController
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
        $this->crud->setEntityNameStrings('Receiving', 'Receivings');

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
                // 'type'      => 'select2_table_purchase_order_products',
                'type'      => 'select2_scoped',
                'name'      => 'purchase_order_id',
                'entity'    => 'purchase_order',
                'attribute' => 'id',
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
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

        // ------ CRUD ACCESS
        $this->crud->allowAccess('show');

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->orderBy('created_at', 'desc');
    }

    public function index()
    {
        // Remove and disable receiving when there is nothing to receive.
        if (PurchaseOrder::notCompleted()->count() == 0)
            $this->crud->removeButton('create');

        return parent::index();
    }

    public function create()
    {
        // Disable create when there is nothing to receive.
        if (PurchaseOrder::notCompleted()->count() == 0) {
            \Alert::warning('There are no Purchase Orders to receive.')->flash();
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

            // $receiving = PurchaseOrderReceiving::create(
            //     collect($request->only(['purchase_order_id', 'receiving', 'remark']))
            //     ->merge($product)
            //     ->merge([
            //         'purchase_order_product_id' => $product->id,
            //         'receiver_id' => \Auth::user()->id
            //     ])
            //     ->toArray()
            // );
        }

        // dd($receiving);
        
        return redirect()->route('crud.receiving.index');

        // // your additional operations before save here
        // $redirect_location = parent::storeCrud($request);
        // // your additional operations after save here
        // // use $this->data['entry'] or $this->crud->entry
        // return $redirect_location;
    }

    public function show($id)
    {
        $this->crud->setShowView('admin.receivings.show');

        return parent::show($id);
    }

    public function edit($id)
    {
        // Disable the edit form.
        abort(404);
    }

    public function update(UpdateRequest $request, $receiving_id)
    {
        // Disable the edit form submission.
        abort(404);

        // $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        // $receiving = PurchaseOrderReceiving::findOrFail($receiving_id);
        // $products = json_decode($request->products_json);

        // foreach ($products as $product) {

        //     // TODO: validate receiving
            
        //     PurchaseOrderReceivingProduct::findOrFail($product->id)->update([
        //         'quantity' => $product->quantity,
        //     ]);
        // }
        
        // return redirect()->route('crud.receiving.index');
    }

    public function destroy($id)
    {
        // Disable deleting of purchase orders.
        abort(404);

        // $this->crud->hasAccessOrFail('delete');

        // // Delete associated items
        // PurchaseOrder::findOrFail($id)->products()->delete();

        // return $this->crud->delete($id);
    }
}
