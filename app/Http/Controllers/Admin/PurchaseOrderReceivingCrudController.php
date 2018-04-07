<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrderProductReceiving;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ReceivingRequest as StoreRequest;
use App\Http\Requests\ReceivingRequest as UpdateRequest;

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
       
       $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->child_resource_included = ['select' => false, 'number' => false];
        $this->crud->addFields([
            [
               'label'     => 'Purchase Order #',
               'type'      => 'select2',
               'name'      => 'purchase_order_id',
               'entity'    => 'purchase_order',
               'attribute' => 'id',
               'model'     => 'App\Models\PurchaseOrder',
            ]
        ]);

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS
        
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
