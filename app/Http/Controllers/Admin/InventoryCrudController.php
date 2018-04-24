<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Location;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InventoryRequest as StoreRequest;
use App\Http\Requests\InventoryRequest as UpdateRequest;
use App\Http\Requests\ReplenishInventoryRequest;
use App\Http\Requests\DepleteInventoryRequest;
use Illuminate\Http\Request;

class InventoryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->setupBasicCrudInformation();

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
           'label'     => 'Metric',
           'type'      => 'select2',
           'name'      => 'metric_id', // the db column for the foreign key
           'entity'    => 'metric', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           // 'wrapperAttributes' => [
           //     'class' => 'form-group col-md-6'
           //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            // 'tab' => 'Basic Info',
        ]);

        $this->crud->addField([  // Select2
           'label'     => 'Category',
           'type'      => 'select2',
           'name'      => 'category_id', // the db column for the foreign key
           'entity'    => 'category', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           // 'wrapperAttributes' => [
           //     'class' => 'form-group col-md-6'
           //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            // 'tab' => 'Basic Info',
        ]);

        $this->crud->addField([ // Text
            'name'  => 'name',
            'label' => 'Name',
            'type'  => 'text',
            // 'tab'   => 'Texts',

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

        // Custom SKU field
        $this->crud->addField([
            'name'  => 'sku_code',
            'label' => 'SKU',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // Textarea
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'textarea',
            // 'tab'   => 'Texts',
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
           'label'     => 'SKU', // Table column heading
           'type'      => 'select',
           'name'      => 'inventory_id', // the column that contains the ID of that connected entity;
           'entity'    => 'sku', // the method that defines the relationship in your Model
           'attribute' => 'code', // foreign key attribute that is shown to user
        ]);

        // $this->crud->addColumn(); // add a single column, at the end of the stack
        $this->crud->addColumns(['name', 'description']); // add multiple columns, at the end of the stack

        $this->crud->addColumn([
           // 1-n relationship
           'label'     => 'Category', // Table column heading
           'type'      => 'select',
           'name'      => 'category_id', // the column that contains the ID of that connected entity;
           'entity'    => 'category', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
        ]);

        $this->crud->addColumn([
           // 1-n relationship
           'label'     => 'Metric', // Table column heading
           'type'      => 'select',
           'name'      => 'metric_id', // the column that contains the ID of that connected entity;
           'entity'    => 'metric', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
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
        
        $this->crud->addButtonFromView('line', 'inventory_stock_decrease', 'inventory_stock_decrease', 'beginning');
        $this->crud->addButtonFromView('line', 'inventory_stock_increase', 'inventory_stock_increase', 'beginning');

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
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        
        // Store custom SKU if filled
        if ($request->filled('sku_code'))
          $this->crud->entry->createSku($request->sku_code, true);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        
        // Update custom SKU if filled
        if ($request->filled('sku_code'))
          $this->crud->entry->updateSku($request->sku_code);

        return $redirect_location;
    }

    /**
     * Show the form for adding stock to the specified stock.
     * @return view
     */
    public function getAddStock(Request $request, $inventory_id)
    {
        // WIP setup permissions
        // $this->crud->hasAccessOrFail('add');

        $this->setupBasicCrudInformation();

        $inventory = Inventory::find($inventory_id);

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($inventory_id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($inventory_id);
        // $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['title'] = 'Add Stock';
        $this->crud->route = route('inventory.stocks.add', $inventory_id);
        $this->crud->entity_name = 'Stock';

        $this->data['id'] = $inventory_id;

        // Custom fields
        
        // Remove fields used by the Inventory CRUD.
        $this->crud->removeFields([
          'metric_id',
          'category_id',
          'name',
          'description',
          'sku_code',
        ], 'both');

        // static field
        $this->crud->addField([
            'name'       => 'item',
            'label'      => 'Item',
            'type'       => 'text',
            'default'    => $inventory->name,
            'attributes' => ['disabled' => 'disabled'],
            'tab'        => 'Primary',
        ]);

        $location_options = Location::orderBy('name', 'asc')->pluck('name', 'id');
        $this->crud->addField([ // select_from_array
            'name'        => 'location_id',
            'label'       => "Location",
            'type'        => 'select_from_array',
            'options'     => $location_options,
            'allows_null' => false,
            'tab'         => 'Primary',
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
            'name'  => 'reason',
            'label' => 'Reason',
            'type'  => 'text',
            'tab'   => 'Optional',
        ]);

        return view('admin.inventories.add_stock', $this->data);
    }

    /**
     * Execute the replenishment of stocks from the form submitted.
     * @return view
     */
    public function postAddStock(ReplenishInventoryRequest $request, $inventory_id)
    {
        $location = Location::find($request->location_id);
        $item = Inventory::find($inventory_id);
        
        try {
            // Here we assume there is already a stock record on the given location.
            $stock = $item->getStockFromLocation($location);
            $stock->add($request->add_quantity, $request->reason, $request->cost);
        } catch (\Stevebauman\Inventory\Exceptions\StockNotFoundException $e) {
            // There is no stock on the given location, let's create a new one.
            $item->createStockOnLocation($request->add_quantity, $location);
        }

        \Alert::success('Replenished ' .$item->name. ' stock on ' . $location->name . '.')->flash();

        return redirect()->route('crud.inventory.index');
    }

    /**
     * Show the form for removing stocks to the specified stock.
     * @return view
     */
    public function getRemoveStock(Request $request, $inventory_id)
    {
        // WIP setup permissions
        // $this->crud->hasAccessOrFail('remove');

        $this->setupBasicCrudInformation();

        $inventory = Inventory::find($inventory_id);

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($inventory_id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($inventory_id);
        $this->data['title'] = 'Remove Stock';
        $this->crud->route = route('inventory.stocks.remove', $inventory_id);

        $this->data['id'] = $inventory_id;

        // Custom fields
        
        // Remove fields used by the Inventory CRUD.
        $this->crud->removeFields([
          'metric_id',
          'category_id',
          'name',
          'description',
          'sku_code',
        ], 'both');

        // static field
        $this->crud->addField([
            'name'       => 'item',
            'label'      => 'Item',
            'type'       => 'text',
            'default'    => $inventory->name,
            'attributes' => ['disabled' => 'disabled'],
            'tab'        => 'Primary',
        ]);

        $location_options = Location::orderBy('name', 'asc')->pluck('name', 'id');
        $this->crud->addField([ // select_from_array
            'name'        => 'location_id',
            'label'       => "Location",
            'type'        => 'select_from_array',
            'options'     => $location_options,
            'allows_null' => false,
            'tab'         => 'Primary',
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

        return view('admin.inventories.remove_stock', $this->data);

    }

    /**
     * Execute the depletion of stocks submitted byt the form.
     * @return view
     */
    public function postRemoveStock(DepleteInventoryRequest $request, $inventory_id)
    {
        $location = Location::find($request->location_id);
        $item = Inventory::find($inventory_id);
        
        try {
            $stock = $item->getStockFromLocation($location);
        } catch (\Stevebauman\Inventory\Exceptions\StockNotFoundException $e) {
            // There is no stock on the given location, let's warn the user to create it first.
            \Alert::warning($e->getMessage())->flash();
            return back()->withInput();
        }

        try {
            $stock->remove($request->remove_quantity, $request->reason);
        } catch (\Stevebauman\Inventory\Exceptions\NotEnoughStockException $e) {
            \Alert::warning($e->getMessage())->flash();
            return back()->withInput();
        }

        \Alert::success('Depleted ' .$item->name. ' stock on ' . $location->name . '.')->flash();
        return redirect()->route('crud.inventory.index');
    }

    private function setupBasicCrudInformation()
    {
        $this->crud->setModel('App\Models\Inventory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/inventory');
        $this->crud->setEntityNameStrings('inventory', 'inventories');
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('inventories.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('inventories.create')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('inventories.update')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('inventories.delete')) {
            $this->crud->allowAccess('delete');
        }
    }
}
