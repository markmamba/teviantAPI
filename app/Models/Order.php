<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Order extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    //protected $table = 'orders';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['status_id', 'packer_id', 'packed_at'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
   
    /**
     * Return true if the order has sufficient reservations else, return the defiency.
     * @return boolean
     */
    public function isSufficient()
    {
        if ($this->products->sum('quantity') - $this->reservations->sum('quantity_reserved'))
            return false;
        else
            return true;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
   
    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function shippingAddress()
    {
        return $this->hasOne('App\Models\OrderShippingAddress');
    }

    public function billingAddress()
    {
        return $this->hasOne('App\Models\OrderBillingAddress');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status_id');
    }

    public function reservations()
    {
        return $this->hasManyThrough('App\Models\OrderProductReservation', 'App\Models\OrderProduct');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\OrderCarrier', 'order_id');
    }

    public function packer()
    {
        return $this->belongsTo('App\User', 'packer_id');
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
   
    public function getProductsCountAttribute()
    {
        return $this->products->count();
    }

    public function getFullUserNameAttribute()
    {
        return $this->shippingAddress->name;
    }

    public function getFullShippingAddressAttribute()
    {
        return $this->shippingAddress->address1 . ', ' . $this->shippingAddress->address1 . ', ' . $this->shippingAddress->city . ', ' . $this->shippingAddress->county . ', ' . $this->shippingAddress->postal_code;
    }

    public function getFullBillingAddressAttribute()
    {
        return $this->billingAddress->address1 . ', ' . $this->billingAddress->address1 . ', ' . $this->billingAddress->city . ', ' . $this->billingAddress->county . ', ' . $this->billingAddress->postal_code;
    }

    public function getTotalAttribute()
    {
        return $this->products->sum('price');
    }

    public function getDeficiencyAttribute()
    {
        return $this->products->sum('quantity') - $this->reservations->sum('quantity_reserved');
    }
}
