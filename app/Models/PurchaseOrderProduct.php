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

    /**
     * Return quantity_received as the sum of received quantities.
     * @return int
     */
    public function getQuantityReceivedAttribute()
    {
        return $this->receiving_products()->sum('quantity');
    }

    /**
     * Return quantity_pending as the sum of pending quantities to be received.
     * @return [type] [description]
     */
    public function getQuantityPendingAttribute()
    {
        return $this->quantity - $this->quantity_received;
    }

    /**
     * Return is_completed if the product quantity order has been fully received or not.
     * @return boolean
     */
    public function getIsCompletedAttribute()
    {
        if ($this->quantity == $this->quantity_received)
            return true;
        else
            return false;
    }

    /**
     * Return completed_at as the datetime at which the lastreceiving has fullfilled the quantity ordered.
     * @return datetime
     */
    public function getCompletedAtAttribute()
    {
        if ($this->is_completed)
            return $this->receiving_products()->orderBy('created_at', 'desc')->first()->created_at;
    }
}
