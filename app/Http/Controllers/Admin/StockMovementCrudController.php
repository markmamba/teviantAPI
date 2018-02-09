<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Controllers\Admin\InventoryStockCrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InventoryStockRequest as StoreRequest;
use App\Http\Requests\InventoryStockRequest as UpdateRequest;

class StockMovementCrudController extends InventoryStockCrudController
{
    public function setup()
    {
        parent::setup();

        // $this->crud->setModel('App\Models\InventoryStockMovement');

        // get the stock_id parameter
        $stock_id = \Route::current()->parameter('stock_id');

        // set a different route for the admin panel buttons
        $this->crud->setRoute("admin/stock/".$stock_id."/movement");

        // show only that stocks's movements
        $this->crud->addClause('where', 'stock_id', '==', $stock_id);
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
}
