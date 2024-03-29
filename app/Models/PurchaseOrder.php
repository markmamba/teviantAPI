<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class PurchaseOrder extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'purchase_orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['supplier_id', 'remark', 'sent_at', 'completed_at'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function products()
    {
        return $this->hasMany('App\Models\PurchaseOrderProduct');
    }

    public function receivings()
    {
        return $this->hasMany('App\Models\PurchaseOrderReceiving', 'purchase_order_id');
    }

    public function receiving_products()
    {
        return $this->hasManyThrough('App\Models\PurchaseOrderReceivingProduct', 'App\Models\PurchaseOrderProduct');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeNotCompleted($query)
    {
        return $query->whereNull('completed_at');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getProductsPriceSumAttribute()
    {
        return $this->products()->sum('price');
    }

    public function getPriceTotalAttribute()
    {
        return $this->products()->sum(DB::raw('price * quantity'));
    }

    public function getCreatedAtForHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function isCompleted()
    {
        return $this->products()->sum('quantity') === $this->receiving_products()->sum('purchase_order_receiving_products.quantity');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
