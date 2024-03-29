<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Location;
use App\Http\Requests\ReplenishStockRequest;
use App\Http\Requests\DepleteStockRequest;
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
        $this->setupBasicCrudInformation();

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
            'tab'   => 'Optional',
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
            'tab'   => 'Optional',
        ]);

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        $this->crud->addColumns([
            [
                'label' => 'SKU',
                'name'  => 'sku_code',
                'type'  => 'text',
            ],
            [
                // 1-n relationship
               'label'     => 'Product', // Table column heading
               'type'      => 'select',
               'name'      => 'inventory_id', // the column that contains the ID of that connected entity;
               'entity'    => 'item', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
            ],
            [
                // 1-n relationship
               'label'     => 'Location',
               'type'      => 'select',
               'name'      => 'location_id',
               'entity'    => 'location',
               'attribute' => 'name',
            ],
            [
                'label' => 'Quantity',
                'name'  => 'quantity',
                'type'  => 'number',
            ],
            [
                'label' => 'Aisle-Row-Bin',
                'name'  => 'aisle_row_bin',
                'type'  => 'text',
            ],
            [
                'label' => 'Reservations',
                'name'  => 'pending_reservations_count',
                'type'  => 'number',
            ],
            [
               'name' => 'quantity_available',
               'label' => "Available",
               'type' => 'view',
               'view' => 'admin.inventory_stocks.columns.available_view',
            ],
        ]); // add multiple columns, at the end of the 

        $this->crud->addField([ // Text
            'name'  => 'aisle',
            'label' => 'Aisle',
            'type'  => 'text',
            'tab'   => 'Optional',

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
            'tab'   => 'Optional',
        ]);

        $this->crud->addField([ // Text
            'name'  => 'bin',
            'label' => 'Bin',
            'type'  => 'text',
            'tab'   => 'Optional',
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
        $this->crud->addButtonFromView('line', 'stock_decrease', 'stock_decrease', 'beginning');
        $this->crud->addButtonFromView('line', 'stock_increase', 'stock_increase', 'beginning');

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |-------------------------------------------------------------------------
        */
        $this->setPermissions();

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
        $this->crud->hasAccessOrFail('store');

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
        $this->crud->hasAccessOrFail('update');

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
        $this->crud->hasAccessOrFail('add');

        return view('admin.stocks.add');
    }
    
    private function storeCrudCustom(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('store');

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

    /**
     * Show the form for adding stock to the specified stock.
     * @return view
     */
    public function getAddStock(Request $request, $stock_id)
    {
        // Temporary issue fix where setup() is not called when calling this method from the route.
        $this->setPermissions();

        $this->crud->hasAccessOrFail('add');

        // WIP setup permissions
        // $this->crud->hasAccessOrFail('add');

        $this->setupBasicCrudInformation();

        $stock = InventoryStock::find($stock_id);

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($stock_id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($stock_id);
        // $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['title'] = 'Add Stock';
        $this->crud->route = route('post_add_stock', $stock_id);

        $this->data['id'] = $stock_id;

        // Custom fields
        
        $this->crud->addField([  // Select2
            'label'     => 'Item',
            'type'      => 'select2',
            'name'      => 'inventory_id', // the db column for the foreign key
            'entity'    => 'item', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => $stock->inventory_id,
            'tab'       => 'Primary',
            'attributes' => [
                'disabled' => 'disabled'
            ],
        ]);
        
        $this->crud->addField([  // Select2
           'label'     => 'Location',
           'type'      => 'select2',
           'name'      => 'location_id', // the db column for the foreign key
           'entity'    => 'location', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'default'   => $stock->location_id,
            'tab'      => 'Primary',
        ]);

        /**
         * Notice, add_quantity will be quantity.
         * We use another name instead so the form is not
         * auto-filled with the current value on the database.
         */
        $this->crud->addField([   // Number
            'name'    => 'add_quantity',
            'label'   => 'Quantity',
            'type'    => 'number',
            'tab'     => 'Primary',
            'default' => 0,
        ]);

        $this->crud->addField([   // Number
            'name'  => 'cost',
            'label' => 'Cost',
            'type'  => 'number',
            'tab'   => 'Optional',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'cost',
            'label' => 'Cost',
            'type'  => 'number',
            'tab'   => 'Optional',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'reason',
            'label' => 'Reason',
            'type'  => 'text',
            'tab'   => 'Optional',
        ]);

        // dd(
        //     $this->data['crud'] = $this->crud,
        //     $this->data['entry'],
        //     $this->data['saveAction'] = $this->getSaveAction(),
        //     $this->data['fields'] = $this->crud->getUpdateFields($stock_id),
        //     $this->data['title'] = 'Add Stock',
        //     $this->crud->route
        // );

        return view('admin.stocks.add', $this->data);
    }

    /**
     * Execute the replenishment of stocks from the form submitted.
     * @return view
     */
    public function postAddStock(ReplenishStockRequest $request, $stock_id)
    {
        // Temporary issue fix where setup() is not called when calling this method from the route.
        $this->setPermissions();

        $this->crud->hasAccessOrFail('add');

        $location = Location::find($request->location_id);
        $stock = InventoryStock::find($stock_id);
        $stock->add($request->add_quantity, $request->reason, $request->cost);

        \Alert::info('Replenished stock on location.')->flash();

        return redirect()->route('crud.stock.index');
    }

    /**
     * Show the form for removing stocks to the specified stock.
     * @return view
     */
    public function getRemoveStock(Request $request, $stock_id)
    {
        // Temporary issue fix where setup() is not called when calling this method from the route.
        $this->setPermissions();

        $this->crud->hasAccessOrFail('subtract');

        // WIP setup permissions
        // $this->crud->hasAccessOrFail('remove');

        $this->setupBasicCrudInformation();

        $stock = InventoryStock::find($stock_id);

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($stock_id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($stock_id);
        $this->data['title'] = 'Remove Stock';
        $this->crud->route = route('post_remove_stock', $stock_id);

        $this->data['id'] = $stock_id;

        // Custom fields
        
        $this->crud->addField([  // Select2
            'label'     => 'Item',
            'type'      => 'select2',
            'name'      => 'inventory_id', // the db column for the foreign key
            'entity'    => 'item', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => $stock->inventory_id,
            'tab'       => 'Primary',
            'attributes' => [
                'disabled' => 'disabled'
            ],
        ]);

        $this->crud->addField([  // Select2
            'label'     => 'Location',
            'type'      => 'select2',
            'name'      => 'location_id', // the db column for the foreign key
            'entity'    => 'location', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => $stock->location_id,
            'tab'       => 'Primary',
        ]);

        /**
         * Notice, remove_quantity will be quantity.
         * We use another name instead so the form is not
         * auto-filled with the current value on the database.
         */
        $this->crud->addField([   // Number
            'name'    => 'remove_quantity',
            'label'   => 'Quantity',
            'type'    => 'number',
            'tab'     => 'Primary',
            'default' => 0,
        ]);

        $this->crud->addField([   // Text
            'name'  => 'reason',
            'label' => 'Reason',
            'type'  => 'text',
            'tab'   => 'Optional',
        ]);

        return view('admin.stocks.remove', $this->data);

    }

    /**
     * Execute the depletion of stocks submitted by the form.
     * @return view
     */
    public function postRemoveStock(DepleteStockRequest $request, $stock_id)
    {
        // Temporary issue fix where setup() is not called when calling this method from the route.
        $this->setPermissions();
        
        $this->crud->hasAccessOrFail('subtract');

        $stock = InventoryStock::find($stock_id);
        
        try {
            $stock->remove($request->remove_quantity, $request->reason);

            \Alert::info('Depleted stock on location.')->flash();

            return redirect()->route('crud.stock.index');

        } catch (\Stevebauman\Inventory\Exceptions\NotEnoughStockException $e) {
            \Alert::warning($e->getMessage())->flash();
            return back()->withInput();
        }
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'add', 'subtract']);

        // Allow list access
        if ($user->can('stocks.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('stocks.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow create access
        if ($user->can('stocks.store')) {
            $this->crud->allowAccess('store');
        }

        // Allow update access
        if ($user->can('stocks.update')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('stocks.delete')) {
            $this->crud->allowAccess('delete');
        }

        // Allow add access
        if ($user->can('stocks.add')) {
            $this->crud->allowAccess('add');
        }

        // Allow subtract access
        if ($user->can('stocks.subtract')) {
            $this->crud->allowAccess('subtract');
        }
    }

    private function setupBasicCrudInformation()
    {
        $this->crud->setModel('App\Models\InventoryStock');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/stock');
        $this->crud->setEntityNameStrings('stock', 'stocks');

        // $this->crud->setFromDb();
    }
}
