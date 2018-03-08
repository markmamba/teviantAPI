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
    // protected $fillable = [];
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
}
