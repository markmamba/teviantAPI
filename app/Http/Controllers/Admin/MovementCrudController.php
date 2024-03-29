<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventoryStockMovement;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InventoryStockMovementRequest as StoreRequest;
use App\Http\Requests\InventoryStockMovementRequest as UpdateRequest;
use App\Http\Requests\RollbackMovementRequest;
use Illuminate\Support\Facades\Route;

class MovementCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\InventoryStockMovement');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/movement');
        $this->crud->setEntityNameStrings('movement', 'movements');

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
            'name'      => 'stock_id', // the column that contains the ID of that connected entity;
            'entity'    => 'stock', // the method that defines the relationship in your Model
            'attribute' => 'sku_code', // foreign key attribute that is shown to user
            'key'       => 'stock_sku_code',
            'model' => "App\Models\InventoryStock",
                'searchLogic' => function ($query, $column, $searchTerm) {
                        $query->orWhereHas('stock.item.sku', function ($query) use ($column, $searchTerm) {
                            $query->where('code', 'like', '%'.$searchTerm.'%');
                        });
                    }
        ]);

        // 1-n relationship column with custom search logic
        $this->crud->addColumn([
            'label'     => 'Name', // Table column heading
            'type'      => 'select',
            'name'      => 'stock_id', // the column that contains the ID of that connected entity;
            'entity'    => 'stock', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'key'       => 'stock_name',
            'model' => "App\Models\InventoryStockMovement",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('stock.item', function ($query) use ($column, $searchTerm) {
                        $query->where('name', 'like', '%'.$searchTerm.'%');
                    });
                }
        ]);

        // $options = InventoryStockMovement::with('stock.item')
        //     ->whereHas('stock.item', function ($query) use ($term) {
        //         $query->where('name', 'like', '%'.$term.'%');
        //     })
        //     ->get();

        $this->crud->addColumns(['before', 'after', 'cost', 'reason', 'created_at']);

        $this->crud->addColumn([
           // 1-n relationship
           'label'     => 'User', // Table column heading
           'type'      => 'select',
           'name'      => 'user_id', // the column that contains the ID of that connected entity;
           'entity'    => 'user', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'tab'       => 'Primary',
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
        
        // $this->crud->removeAllButtonsFromStack('line');
        $this->crud->addButtonFromView('line', 'movement_rollback', 'movement_rollback', 'beginning');
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

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
        
        $this->crud->orderBy('created_at', 'desc');
        
        $this->crud->addFilter([ // select2_ajax filter
            'name' => 'stock_id',
            'type' => 'select2_ajax',
            'label'=> 'Name',
            'placeholder' => 'Pick a stock name'
            ],
            url('admin/ajax/inventory-name-options'), // the ajax route
            function($value) { // if the filter is active
                // $this->crud->with('stock.item');
                // $this->crud->addClause('where', 'name', $value);
                $this->crud->addClause('whereHas', 'stock.item', function ($query) use ($value) {
                    $query->where('name', 'like', '%'.$value.'%');
                });

                // function ($query, $column, $searchTerm) {
                //         $query->orWhereHas('stock.item.sku', function ($query) use ($column, $searchTerm) {
                //             $query->where('code', 'like', '%'.$searchTerm.'%');
                //         });
                //     }
                
            }
        );
    }

    public function create()
    {
        // Disable the create function.
        abort(404);
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

    /**
     * AJAX filter: Inventory names options for the filtering stock names.
     * @return array
     */
    public function inventoryNameOptions() {
        $term = $this->request->input('term');
        
        $options = InventoryStockMovement::with('stock.item')
            ->whereHas('stock.item', function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%');
            })
            ->get();

        return collect($options->pluck('stock.item.name', 'stock.item.name'))->unique();
    }

    /**
     * Show the form for rolling back the given movement.
     * @return view
     */
    public function rollbackForm($id)
    {
        $this->crud->hasAccessOrFail('rollback');

        $this->crud->model = InventoryStockMovement::findOrFail($id);
        $this->crud->route = route('movement.rollback', $this->crud->model->id);

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = 'Rollback Movement';

        $this->crud->addField([
            'label' => 'Reason',
            'name' => 'reason',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Enter an optional reason.'
            ]
        ]);
        
        return view('admin.movements.rollback', $this->data);
    }

    /**
     * Trigger a rollback on a specific movement.
     */
    public function rollback(RollbackMovementRequest $request, $movement_id)
    {
        $this->crud->hasAccessOrFail('rollback');

        $movement = InventoryStockMovement::find($movement_id);

        try {
            $movement->rollback();

            // Add the reason for the rollback
            $movement->stock->getLastMovement()->update($request->only(['reason']));
            
            \Alert::success('Rollbacked movement.')->flash();

            return redirect()->route('crud.movement.index');

        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return back();
        }
    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'store', 'show', 'rollback']);

        // Allow list access
        if ($user->can('movements.index')) {
            $this->crud->allowAccess('list');
        }

        // Allow show access
        if ($user->can('movements.show')) {
            $this->crud->allowAccess('show');
        }

        // Allow rollback access
        if ($user->can('movements.rollback')) {
            $this->crud->allowAccess('rollback');
        } else {
        }
    }
}
