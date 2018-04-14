<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
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
                'type'      => 'select2',
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
                'label' => 'Remark',
                'name'  => 'remark',
                'type'  => 'text',
                'tab'   => 'Optionals',
            ],
            [
                'label'     => 'Receiver',
                'type'      => 'select2',
                'name'      => 'receiver_id',
                'entity'    => 'receiver',
                'attribute' => 'name',
                'tab'       => 'Primary',
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
        ]);

        // ------ CRUD BUTTONS
        $this->crud->addButtonFromView('line', 'purchase_order_receiving_view', 'purchase_order_receiving_view', 'beginning');

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->orderBy('created_at', 'desc');
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

        $products = json_decode($request->products_json);

        // dd($request->all(), $products);

        foreach ($products as $product) {

            // TODO: validate receiving
            
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

    public function show($id)
    {
        // $this->crud->hasAccessOrFail('show');

        // set columns from db
        $this->crud->setFromDb();

        // cycle through columns
        foreach ($this->crud->columns as $key => $column) {
            // remove any autoset relationship columns
            if (array_key_exists('model', $column) && array_key_exists('autoset', $column) && $column['autoset']) {
                $this->crud->removeColumn($column['name']);
            }
        }

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;

        // remove preview button from stack:line
        $this->crud->removeButton('preview');
        $this->crud->removeButton('delete');

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }
}
