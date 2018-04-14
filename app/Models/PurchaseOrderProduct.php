<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
	protected $fillable = [
		'product_id',
		'purchase_order_id',
		'price',
		'quantity',
	];

	public function purchase_order()
	{
		return $this->belongsTo('App\Models\PurchaseOrder');
	}

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'product_id');
    }

    public function receivings()
    {
    	return $this->hasMany('App\Models\PurchaseOrderProductReceiving', 'product_id');
    }

    public function receiving_products()
    {
    	return $this->hasMany('App\Models\PurchaseOrderReceivingProduct');
    }
}
