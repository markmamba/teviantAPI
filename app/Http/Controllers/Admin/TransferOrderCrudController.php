<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Location;
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
                'label' => 'Aisle',
                'type'  => 'text',
                'name'  => 'aisle',
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
                'hint'  => 'Note: Aisle, Row and Bin will only be used if the selected item(s) is not yet in the selected location.'
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
        $this->crud->orderBy('created_at', 'desc');
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

        // Allow delete access
        if ($user->can('transfer_orders.complete')) {
            $this->crud->allowAccess('complete');
        }
    }

    /**
     * Show the form for completing the Transfer Order.
     * @return view
     */
    public function completeForm($id)
    {
        $this->crud->hasAccessOrFail('complete');

        $this->crud->model = TransferOrder::findOrFail($id);
        $this->guardCompleted($this->crud->model);
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
            'aisle',
            'row',
            'bin',
            'remark',
        ]);
        
        return view('admin.transfer_orders.complete_form', $this->data);
    }

    /**
     * Complete the Transfer Order from the submitted form.
     * @return redirect
     */
    public function complete(Request $request, $id)
    {
        /**
         * Pseudo:
         * 1 - Move stocks to specified stock and location.
         * 2 - Reserve stocks for pending orders.
         * 3 - Mark transfer order as complete.
         */
        // dd($id, $request->all());
        
        $transfer_order = TransferOrder::findOrFail($id);

        $this->guardCompleted($transfer_order);

        // 1
        $this->transferOrderStock($transfer_order);

        // // 2
        // $this->reserveStock($request, $transfer_order);

        // 3
        $transfer_order->update(['transferred_at' => \Carbon\Carbon::now()]);

        // die('WIP');

        return redirect()->route('crud.transfer-order.index');
    }

    private function transferOrderStock($transfer_order)
    {
        // TODO: Store receivings on a stock (receivings location) and
        // use $stock->move($from_location, $to_location)
        // for better receivings stock tracking

        $location = Location::find($transfer_order->location_id);
        $item = Inventory::find($transfer_order->purchase_order_receiving_product_id);
        $stock = InventoryStock::find($item->id);
        $stock = InventoryStock::where('inventory_id', $item->id)->where('location_id', $location->id)->first();
        $reason = 'New stock from Transfer Order #'.$transfer_order->id;

        // dd($transfer_order->location, $item, $stock);
        
        // Add the stocks to the existing inventory stock location else create a new one.
        if ($stock) {
            // Add to existing inventory stock.
            $stock->add($transfer_order->quantity, $reason);
        } else {
            // Create new inventory stock to add new stocks to.
            $stock               = new InventoryStock;
            $stock->inventory_id = $item->id;
            $stock->location_id  = $location->id;
            $stock->quantity     = $transfer_order->quantity;
            // $stock->cost         = '5.20';
            $stock->reason       = $reason;
            $stock->aisle        = isset($transfer_order->aisle) ? $transfer_order->aisle : null;
            $stock->row          = isset($transfer_order->row) ? $transfer_order->row : null;
            $stock->bin          = isset($transfer_order->bin) ? $transfer_order->bin : null;
            $stock->save();
        }

        // Link the stock movement to the transfer order.
        $stock->getLastMovement()->update(['transfer_order_id' => $transfer_order->id]);

        // dd($location, $item, $stock);
        
        return $stock;
    }

    /**
     * Guard completed Transfer Orders.
     * @param  TransferOrder $transfer_order
     * @return view/HTTP/void
     */
    private function guardCompleted(TransferOrder $transfer_order)
    {
        if ($transfer_order->isCompleted())
            abort(400);
    }

    // TODO: Move this operation to the Receivings controller
    // /**
    //  * Create the Receivings location if does not exist.
    //  * @return App\Model\Location - The Receivings location.
    //  */
    // private function createReceivingsLocation()
    // {
    //     $receivings_location = App\Models\Location::where('name', 'Receivings')->first();
    //     if ($receivings_location == null) {
    //         App\Models\Location::create(['name' => 'Receivings']);
    //     }
    // }
}
