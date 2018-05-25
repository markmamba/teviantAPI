<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\PurchaseOrderReceivingProduct;
use App\Models\TransferOrder;
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
        $this->setPermissions();

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
                'label' => 'Quantity',
                'type'  => 'transfer_orders_quantity',
                'name'  => 'quantity',
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
                'tab'   => 'Optionals',
            ],
            [
                'label' => 'Row',
                'type'  => 'text',
                'name'  => 'row',
                'tab'   => 'Optionals',
            ],
            [
                'label' => 'Bin',
                'type'  => 'text',
                'name'  => 'bin',
                'tab'   => 'Optionals',
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
                'label' => 'Quantity',
                'name'  => 'quantity',
                'type'  => 'number',
            ],
            [
                'label' => "Location", // Table column heading
                'type' => "select",
                'name' => 'location_id', // the column that contains the ID of that connected entity;
                'entity' => 'location', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Location", // foreign key model
            ],
            [
                'label' => 'Aisle-Row-Bin',
                'name'  => 'aisle_row_bin',
                'type'  => 'text',
            ],
            [
                'label' => 'Date Transferred',
                'name'  => 'transferred_at',
                'type'  => 'date',
            ],
            [
                'label' => 'Remark',
                'name'  => 'remark',
                'type'  => 'text',
            ],
        ]);

        // ------ CRUD BUTTONS
        $this->crud->removeButton('update');
        $this->crud->addButtonFromView('line', 'complete_transfer_order_button', 'complete_transfer_order_button', 'beginning');
        $this->crud->addButtonFromView('line', 'print_transfer_order_button', 'print_transfer_order_button', 'beginning');

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
    }

    public function index()
    {
        // Remove and disable receiving when there is nothing to receive.
        if (PurchaseOrderReceivingProduct::count() == 0)
            $this->crud->removeButton('create');

        return parent::index();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function edit($id)
    {
        // Disable edit operation
        abort(404);
    }

    public function update(UpdateRequest $request)
    {
        // Disable update operation
        abort(404);
    }

    private function getReceivingsProductOptions()
    {
        $receiving_products = PurchaseOrderReceivingProduct::with('product.inventory')->get();
        
        $receiving_products_options = $receiving_products->filter(function ($value, $key) {
            return $value->quantity_transferrable > 0;
        })->pluck('product.inventory.name', 'product.inventory.id');

        return $receiving_products_options;
    }

    /**
     * Show the printable PDF of the given Transfer Order.
     * @return pdf
     */
    public function printTransferOrder($id)
    {
        $transfer_order = \App\Models\TransferOrder::findOrFail($id);

        $pdf = \PDF::loadView('pdf.transfer_order', compact('transfer_order'));
        return $pdf->stream();
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'delete']);

        // Allow list access
        if ($user->can('transfer_orders.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('transfer_orders.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow delete access
        if ($user->can('transfer_orders.delete')) {
            $this->crud->allowAccess('delete');
        }
    }

    /**
     * Show the form for completing the Transfer Order.
     * @return view
     */
    public function completeForm($id)
    {
        // $this->crud->hasAccessOrFail('complete');

        $this->crud->model = TransferOrder::findOrFail($id);
        $this->crud->route = route('transfer_order.complete', $this->crud->model->id);

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = 'Complete Transfer Order';

        $this->crud->removeFields([
            'purchase_order_receiving_product_id',
            'transfer_orders_quantity',
            'quantity',
            'location_id',
            'ailse',
            'row',
            'bin',
            'remark',
        ]);

        // $this->crud->addField([
        //     'label' => 'Reason',
        //     'name' => 'reason',
        //     'type' => 'text',
        //     'attributes' => [
        //         'placeholder' => 'Enter an optional reason.'
        //     ]
        // ]);
        
        return view('admin.transfer_orders.complete_form', $this->data);
    }

    /**
     * Complete the Transfer Order from the submitted form.
     * @return redirect
     */
    public function complete(Request $request)
    {
        die('WIP');
    }
}
