<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Traits\InventoryStockTrait;

class InventoryStock extends Model
{
    use CrudTrait;
    use InventoryStockTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    //protected $table = 'inventory_stocks';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    
    protected $fillable = [
        'inventory_id',
        'location_id',
        'quantity',
        'aisle',
        'row',
        'bin',
    ];

    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // public function addStock($crud = false)
    // {
    //     $route = route('crud.stock.add', $this->id);

    //     return '<a class="btn btn-xs btn-default" href="' . $route . '" data-toggle="tooltip" title="Add stock"><i class="fa fa-plus"></i> Add</a>';
    // }

    // public function subtractStock($crud = false)
    // {
    //     $route = route('crud.stock.add', $this->id);

    //     return '<a class="btn btn-xs btn-default" href="' . $route . '" data-toggle="tooltip" title="Subtract stock"><i class="fa fa-minus"></i> Subtract</a>';
    // }

    /**
     * Get the HTML button for the link to the stock's movements.
     * @param  boolean $crud
     * @return string
     */
    public function movementsButton($crud = false)
    {
        // dd($crud);
        $route = route('crud.movements.index', $this->id);

        return '<a class="btn btn-xs btn-default" href="' . $route . '" data-toggle="tooltip" title="Manage stock movements"><i class="fa fa-exchange"></i> Movements</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function item()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }

    public function movements()
    {
        return $this->hasMany('App\Models\InventoryStockMovement', 'stock_id');
    }
    
    public function transactions()
    {
        return $this->hasMany('App\Models\InventoryTransaction', 'stock_id', 'id');
    }
    
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
