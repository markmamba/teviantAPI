<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PurchaseOrderRequest as StoreRequest;
use App\Http\Requests\PurchaseOrderRequest as UpdateRequest;

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
        $this->crud->addFields([
            [
               'label'     => 'Supplier',
               'type'      => 'select2',
               'name'      => 'supplier_id',
               'entity'    => 'supplier',
               'attribute' => 'name',
               'tab'       => 'Primary',
            ],
            [
               'label'     => 'Remark',
               'type'      => 'text',
               'name'      => 'remark',
               'tab'       => 'Optionals',
            ],
            [
                'label'     => 'Date Sent',
                'type'      => 'datetime_picker',
                'name'      => 'sent_at',
                'tab'       => 'Optionals',
                'datetime_picker_options' => [
                    'format' => 'YYYY/MM/DD HH:mm',
                ],
                'allows_null' => true,
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
                'label' => 'Remark',
                'name'  => 'remark',
            ],
            [
                'label' => 'Date Created',
                'name'  => 'created_at',
            ],
            [
                'label' => 'Date Sent',
                'name'  => 'sent_at',
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
        $this->crud->with('supplier');
        $this->crud->orderBy('created_at', 'desc');
    }

    public function create()
    {
        if (Supplier::count()) {
            return parent::create();
        }
        else {
            \Alert::warning('Cannot create a purchase order. Add a supplier record first.')->flash();
            return back();
        }
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
