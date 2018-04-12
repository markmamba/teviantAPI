<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceiving extends Model
{
    use CrudTrait;

    protected $fillable = [
    	'id',
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
}
