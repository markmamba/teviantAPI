<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Location;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InventoryStockRequest as StoreRequest;
use App\Http\Requests\InventoryStockRequest as UpdateRequest;

class InventoryStockCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\InventoryStock');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/stock');
        $this->crud->setEntityNameStrings('stock', 'stocks');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');
        
        $this->crud->addField([  // Select2
           'label'     => 'Inventory',
           'type'      => 'select2',
           'name'      => 'inventory_id', // the db column for the foreign key
           'entity'    => 'item', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           // 'wrapperAttributes' => [
           //     'class' => 'form-group col-md-6'
           //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab'      => 'Primary',
        ]);

        $this->crud->addField([  // Select2
           'label'     => 'Location',
           'type'      => 'select2',
           'name'      => 'location_id', // the db column for the foreign key
           'entity'    => 'location', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           // 'wrapperAttributes' => [
           //     'class' => 'form-group col-md-6'
           //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab'      => 'Primary',
        ]);


        $this->crud->addField([   // Number
            'name'  => 'quantity',
            'label' => 'Quantity',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => '$',
            // 'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab'   => 'Primary',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'cost',
            'label' => 'Cost',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => '$',
            // 'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab'   => 'Primary',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'reason',
            'label' => 'Reason',
            'type'  => 'text',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => '$',
            // 'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab'   => 'Primary',
        ]);

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        $this->crud->addColumn([
           // 1-n relationship
           'label'     => 'Inventory', // Table column heading
           'type'      => 'select',
           'name'      => 'inventory_id', // the column that contains the ID of that connected entity;
           'entity'    => 'item', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'tab'       => 'Primary',
        ]);

        $this->crud->addColumn([
           // 1-n relationship
           'label'     => 'Location', // Table column heading
           'type'      => 'select',
           'name'      => 'location_id', // the column that contains the ID of that connected entity;
           'entity'    => 'location', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'tab'       => 'Primary',
        ]);

        $this->crud->addColumns(['quantity', 'aisle', 'row', 'bin']); // add multiple columns, at the end of the 

        $this->crud->addField([ // Text
            'name'  => 'aisle',
            'label' => 'Aisle',
            'type'  => 'text',
            'tab'   => 'Secondary',

            // optional
            //'prefix' => '',
            //'suffix' => '',
            //'default'    => 'some value', // default value
            //'hint'       => 'Some hint text', // helpful text, show up after input
            //'attributes' => [
               //'placeholder' => 'Some text when empty',
               //'class' => 'form-control some-class'
             //], // extra HTML attributes and values your input might need
             //'wrapperAttributes' => [
               //'class' => 'form-group col-md-12'
             //], // extra HTML attributes for the field wrapper - mostly for resizing fields
             //'readonly'=>'readonly',
        ]);

        $this->crud->addField([ // Text
            'name'  => 'row',
            'label' => 'Row',
            'type'  => 'text',
            'tab'   => 'Secondary',
        ]);

        $this->crud->addField([ // Text
            'name'  => 'bin',
            'label' => 'Bin',
            'type'  => 'text',
            'tab'   => 'Secondary',
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
        
        // $this->crud->addButtonFromModelFunction('line', 'subtract_stock', 'subtractStock', 'beginning');
        // $this->crud->addButtonFromModelFunction('line', 'add_stock', 'addStock', 'beginning');
        $this->crud->addButtonFromView('line', 'stock_movements', 'stock_movements', 'beginning');

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
        // dd($request->all());
        // your additional operations before save here
        // $redirect_location = parent::storeCrud($request);
        
        return $this->storeCrudCustom($request);

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

    /**
     * [add description]
     * @param Request $request
     */
    public function add(Request $request)
    {
        return view('admin.stocks.add');
    }
    
    private function storeCrudCustom(StoreRequest $request)
    {
        // dd($request->all());
        
        $item     = Inventory::find($request->inventory_id);
        $location = Location::find($request->location_id);

        // $item->createStockOnLocation($request->quantity, $location);
        
        $stock               = new InventoryStock;
        $stock->inventory_id = $item->id;
        $stock->location_id  = $location->id;
        $stock->quantity     = $request->quantity;
        $stock->aisle        = $request->aisle;
        $stock->row          = $request->row;
        $stock->bin          = $request->bin;
        $stock->cost         = $request->cost;
        $stock->reason       = $request->reason;
        $stock->save();

        // dd($item, $location);

        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        // $item = $this->crud->create($request->except(['save_action', '_token', '_method']));
        // $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }
}
