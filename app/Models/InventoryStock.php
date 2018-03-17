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
     * Get the last movement of the stock.
     * @return App\Models\InventoryStockMovement
     */
    public function getLastMovement()
    {
        return $this->movements()->orderBy('created_at', 'desc')->first();
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

    public function reservations()
    {
        return $this->hasMany('App\Models\OrderProductReservation');
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
   
    /**
     * Get the distant related SKU code.
     * @return string The SKU code of the stock.
     */
    public function getSkuCodeAttribute($value)
    {
        return $this->item->sku_code;
    }

    public function getNameAttribute($value)
    {
        return $this->item->name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
