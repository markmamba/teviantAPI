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
        return $this->hasMany('App\Models\OrderProductReservation', 'stock_id');
    }

    public function pickings()
    {
        return $this->hasManyThrough('App\Models\OrderProductPicking', 'App\Models\OrderProductReservation', 'order_product_id', 'reservation_id');
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
    
    public function getAisleRowBinAttribute()
    {
        return $this->aisle . '-' . $this->row . '-' . $this->bin;
    }

    public function getPendingReservationsCountAttribute()
    {
        return $this->pendingReservationsCount();
    }

    public function getQuantityReservableAttribute()
    {
        return $this->quantityReservable();
    }
    
    public function quantityReservable()
    {
        return abs($this->quantity - $this->pendingReservationsCount());
    }

    public function pendingReservationsCount()
    {
        return $this->reservations()->whereHas('order_product.order', function ($query) {
            $query->whereHas('status', function ($query) {
                $query->whereNotIn('name', ['Packed', 'Shipped', 'Delivered', 'Done', 'Cancelled']);
            });
        })->sum('quantity_reserved');
    }

    public function hasEnoughStockForReservation($quantity = null)
    {
        if (isset($quantity)) {
            if ($quantity <= $this->quantityReservable())
                return true;
            else
                return false;
        } else {
            if ($this->quantityReservable() > 0)
                return true;
            else
                return false;
        }
    }
}
