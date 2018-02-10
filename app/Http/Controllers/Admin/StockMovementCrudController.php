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
        // parent::setup();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('\App\Models\InventoryStockMovement');
        // $this->crud->setRoute(config('backpack.base.route_prefix') . '/movement');
        $this->crud->setEntityNameStrings('stock movement', 'stock movements');

        // get the stock_id parameter
        $stock_id = \Route::current()->parameter('stock_id');

        // set a different route for the admin panel buttons
        $this->crud->setRoute("admin/stock/".$stock_id."/movement");

        // show only that stocks's movements
        $this->crud->addClause('where', 'stock_id', '=', $stock_id);

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD BUTTONS
       
        $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD COLUMNS
        
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

        // ------ ADVANCED QUERIES
        
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
