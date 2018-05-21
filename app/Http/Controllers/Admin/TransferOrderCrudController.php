<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\PurchaseOrderReceivingProduct;
use App\Http\Requests\TransferOrderRequest as StoreRequest;
use App\Http\Requests\TransferOrderRequest as UpdateRequest;
use Illuminate\Http\Request;

class TransferOrderCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\TransferOrder');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/transfer-order');
        $this->crud->setEntityNameStrings('Transfer Order', 'Transfer Orders');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addFields([
            [ // select_from_array
                'label' => "Product",
                'type' => 'select2_from_array',
                'name' => 'purchase_order_receiving_product_id',
                'options' => $this->getReceivingsProductOptions(),
                'allows_null' => true,
                'default' => null,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'tab'   => 'Primary',
            ],
            [
                'label'     => 'Location',
                'type'      => 'select2',
                'name'      => 'location_id',
                'entity'    => 'location',
                'attribute' => 'name',
                'tab'   => 'Primary',
            ],
            [
                'label' => 'Ailse',
                'type'  => 'text',
                'name'  => 'ailse',
                'tab'   => 'Primary',
            ],
            [
                'label' => 'Row',
                'type'  => 'text',
                'name'  => 'row',
                'tab'   => 'Primary',
            ],
            [
                'label' => 'Bin',
                'type'  => 'text',
                'name'  => 'bin',
                'tab'   => 'Primary',
            ],
            [
                'label' => 'Quantity',
                'type'  => 'number',
                'name'  => 'quantity',
                'tab'   => 'Primary',
            ],
            [
                'label' => 'Remark',
                'type'  => 'text',
                'name'  => 'remark',
                'tab'   => 'Optionals',
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns([
            [
                'label' => '#',
                'name'  => 'id',
            ],
            [
                'label'     => 'SKU',
                'type'      => 'view',
                'name'      => null,
                'view'     => "admin.transfer_orders.columns.sku",
            ],
            [
                'label'     => 'Product',
                'type'      => 'view',
                'name'      => 'purchase_order_receiving_product_id',
                'view'     => "admin.transfer_orders.columns.product",
            ],
            [
                'label' => "Location", // Table column heading
                'type' => "select",
                'name' => 'location_id', // the column that contains the ID of that connected entity;
                'entity' => 'location', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Location", // foreign key model
            ],
        ]);

        // ------ CRUD BUTTONS

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
    }

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

    private function getReceivingsProductOptions()
    {
        return PurchaseOrderReceivingProduct::with('product.inventory')->get()
            ->pluck('product.inventory.name', 'product.inventory.id');
    }
}
