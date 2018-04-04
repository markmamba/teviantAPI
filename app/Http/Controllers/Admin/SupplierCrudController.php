<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SupplierRequest as StoreRequest;
use App\Http\Requests\SupplierRequest as UpdateRequest;

class SupplierCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Supplier');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplier');
        $this->crud->setEntityNameStrings('Supplier', 'Suppliers');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addFields([
            [
               'label'     => 'Name',
               'type'      => 'text',
               'name'      => 'name',
               'tab'       => 'Primary',
            ],
            [
               'label'     => 'Address',
               'type'      => 'text',
               'name'      => 'address',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'Postal Code',
               'type'      => 'text',
               'name'      => 'postal_code',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'ZIP Code',
               'type'      => 'text',
               'name'      => 'zip_code',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'Region',
               'type'      => 'text',
               'name'      => 'region',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'City',
               'type'      => 'text',
               'name'      => 'city',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'Country',
               'type'      => 'text',
               'name'      => 'country',
               'tab'       => 'Address Details',
            ],
            [
               'label'     => 'Contact Title',
               'type'      => 'text',
               'name'      => 'contact_title',
               'tab'       => 'Contact Details',
            ],
            [
               'label'     => 'Contact Name',
               'type'      => 'text',
               'name'      => 'contact_name',
               'tab'       => 'Contact Details',
            ],
            [
               'label'     => 'Contact Phone',
               'type'      => 'text',
               'name'      => 'contact_phone',
               'tab'       => 'Contact Details',
            ],
            [
               'label'     => 'Contact Fax',
               'type'      => 'text',
               'name'      => 'contact_fax',
               'tab'       => 'Contact Details',
            ],
            [
               'label'     => 'Contact Email',
               'type'      => 'text',
               'name'      => 'contact_email',
               'tab'       => 'Contact Details',
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns([
            'name',
            'address',
            'postal_code',
            'zip_code',
            'region',
            'city',
            'country',
            'title',
            'name',
            'phone',
            'fax',
            'email',
        ]);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
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
