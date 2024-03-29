<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PurchaseOrderRequest as StoreRequest;
use App\Http\Requests\PurchaseOrderRequest as UpdateRequest;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class PurchaseOrderCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel('App\Models\PurchaseOrder');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/purchase-order');
        $this->crud->setEntityNameStrings('Purchase Order', 'Purchase Orders');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->child_resource_included = ['select' => false, 'number' => false];
        $this->crud->addFields([
            [
                'label'     => 'Supplier',
                'type'      => 'select2',
                'name'      => 'supplier_id',
                'entity'    => 'supplier',
                'attribute' => 'name',
                'tab'       => 'Primary',
            ],
            [ // Table products
                'label'           => 'Products',
                'name'            => 'products',
                'type'            => 'matrix_table',
                'entity_singular' => 'product', // used on the "Add X" button
                'tab'             => 'Primary',
                'columns'         => [
                    [
                        'label'      => 'Product',
                        'type'       => 'matrix_select',
                        'name'       => 'product_id',
                        'entity'     => 'products',
                        'attribute'  => 'sku_code',
                        'size'       => '4',
                        'model'      => "App\Models\Inventory",
                        'attributes' => [
                            'required' => true,
                        ],
                    ],
                    [
                        'label'      => 'Price',
                        'name'       => 'price',
                        'type'       => 'matrix_text',
                        'attributes' => [
                            'type'       => 'text',
                            // 'readonly'   => true,
                            'ng-pattern' => "/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}(?:\.[0-9]{1,2})?$/",
                            'step'       => "0.01",
                        ],
                    ],
                    [
                        'name'       => 'quantity',
                        'label'      => 'Quantity',
                        'type'       => 'matrix_text',
                        'attributes' => [
                            'required' => true,
                            'type'     => 'number',
                            'min'      => 1,
                        ],
                    ],
                ],
                'max'             => Inventory::count(), // maximum rows allowed in the table
                'min'             => 1, // minimum rows allowed in the table
            ],
            [
                'label'      => 'Total',
                'type'       => 'text',
                'name'       => 'total',
                'tab'        => 'Primary',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            [
                'label' => 'Remark',
                'type'  => 'text',
                'name'  => 'remark',
                'tab'   => 'Optionals',
            ],
            [
                'label'                   => 'Date Sent',
                'type'                    => 'datetime_picker',
                'name'                    => 'sent_at',
                'tab'                     => 'Optionals',
                'datetime_picker_options' => [
                    'format' => 'YYYY/MM/DD HH:mm',
                ],
                'allows_null'             => true,
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns([
            [
                'label' => '#',
                'name'  => 'id',
            ],
            [
                'label'     => 'Supplier',
                'type'      => 'select',
                'name'      => 'supplier_id',
                'entity'    => 'supplier',
                'attribute' => 'name',
            ],
            [
                'label' => 'Products',
                'name'  => 'products_count',
            ],
            [
                'label' => 'Total Price',
                'name'  => 'price_total',
            ],
            [
                'label' => 'Date Created',
                'name'  => 'created_at_for_humans',
            ],
            [
                'label' => 'Date Sent',
                'name'  => 'sent_at',
            ],
            [
                'label' => 'Remark',
                'name'  => 'remark',
            ],
            [
                'label' => "Status",
                'name' => 'status',
                'type' => 'view',
                'view' => 'admin.purchase_orders.columns.status_view', // or path to blade file
            ],
        ]);

        // ------ CRUD BUTTONS
        // $this->crud->addButtonFromView('line', 'purchase_order_view', 'purchase_order_view', 'beginning');
        $this->crud->addButtonFromView('line', 'purchase_order_receiving_create', 'purchase_order_receiving_create', 'beginning');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('preview');

        // ------ CRUD ACCESS
        $this->setPermissions();

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->with('supplier');
        $this->crud->addClause('withCount', 'products');
        $this->crud->orderBy('created_at', 'desc');
    }

    public function create()
    {
        if (Supplier::count()) {
            return parent::create();
        } else {
            \Alert::warning('Cannot create a purchase order. Add a supplier record first.')->flash();
            return back();
        }
    }

    public function store(StoreRequest $request)
    {
        // dd($request->all());

        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        // Store the PO's products.
        $products = json_decode($request->products);
        foreach ($products as $product) {
            $new_purchase_order_product = $this->crud->entry->products()->create(
                collect((array) $product)
                    ->merge($request->all())
                    ->toArray()
            );
        }

        return $redirect_location;
    }

    public function show($id)
    {
        $purchase_order = PurchaseOrder::with(['products', 'products.inventory', 'supplier'])->where('id', $id)->first();

        if (!$purchase_order)
            abort(404);

        $crud = $this->crud;

        return view('admin.purchase_orders.show', compact('purchase_order', 'crud'));
    }

    public function edit($id)
    {
        // Disable the edit form.
        abort(404);
    }

    public function update(UpdateRequest $request)
    {
        // Disable the edit form submission.
        abort(404);
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

    /**
     * Show the printable PDF of the given Purchase Order.
     * @return pdf
     */
    public function printOrder($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);

        $pdf = \PDF::loadView('pdf.purchase_order', compact('purchase_order'));
        return $pdf->stream();
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('purchase_orders.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('purchase_orders.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow show access
        if ($user->can('purchase_orders.show')) {
            $this->crud->allowAccess('show');
        }
    }
}
