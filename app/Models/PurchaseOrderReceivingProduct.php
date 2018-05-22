<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceivingProduct extends Model
{
    protected $fillable = [
    	'purchase_order_id',
    	'purchase_order_product_id',
    	'quantity',
    	'receiver_id',
    ];

    public function receiving()
    {
    	return $this->belongsTo('App\Models\PurchaseOrderReceiving', 'purchase_order_receiving_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\PurchaseOrderProduct', 'purchase_order_product_id');
    }

    public function transfer_orders()
    {
        return $this->hasMany('App\Models\TransferOrder');
    }

    public function getQuantityTransferrableAttribute()
    {
        return $this->product->quantity_pending - $this->transfer_orders()->sum('quantity');
    }
}
