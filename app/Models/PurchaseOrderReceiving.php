<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceiving extends Model
{
    use CrudTrait;

    protected $fillable = [
    	'purchase_order_id',
    	'purchase_order_product_id',
    	'quantity',
    	'remark',
    	'receiver_id',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\PurchaseOrderProduct');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function products()
    {
    	return $this->hasMany('App\Models\PurchaseOrderReceivingProduct', 'purchase_order_receiving_id');
    }

    public function receiver()
    {
    	return $this->belongsTo('App\User', 'receiver_id');
    }
}
