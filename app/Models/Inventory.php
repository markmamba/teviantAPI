<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Traits\InventoryTrait;
use Stevebauman\Inventory\Traits\InventoryVariantTrait;

class Inventory extends Model
{
    use CrudTrait;
    use InventoryTrait;
    use InventoryVariantTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'inventories';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'description',
        'metric_id',
        'category_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
   
    /**
     * Alternate findBySku.
     * Because were getting the error with findBySku():
     * 'Inventory class not found'
     * 
     * @param  string $sku
     * @return App\Models\Inventory
     */
    public static function findBySku2($sku = '')
    {
        return self::whereHas('sku', function ($query) use ($sku) {
            $query->where('code', $sku);
        })->first();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    
    public function metric()
    {
        return $this->hasOne('App\Models\Metric', 'id', 'metric_id');
    }
    
    public function sku()
    {
        return $this->hasOne('App\Models\InventorySku', 'inventory_id', 'id');
    }
    
    public function stocks()
    {
        return $this->hasMany('App\Models\InventoryStock', 'inventory_id');
    }
    
    public function suppliers()
    {
        return $this->belongsToMany('App\Models\Supplier', 'inventory_suppliers', 'inventory_id')->withTimestamps();
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct', 'product_id');
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
