<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductReservation extends Model
{
	protected $fillable = [
		'order_product_id',
		'stock_id',
		'user_id',
		'quantity_reserved',
		'quantity_taken',
	];

    public function order_product()
    {
    	return $this->belongsTo('App\Models\OrderProduct');
    }

    public function stock()
    {
    	return $this->belongsTo('App\Models\InventoryStock');
    }

    public function movement()
    {
        return $this->belongsTo('App\Models\InventoryStockMovement', 'movement_id');
    }

    public function picker()
    {
        return $this->belongsTo('App\User', 'picked_by');
    }

    /**
     * Get the deficiency of the reservation.
     * @return int
     */
    public function getDeficiencyAttribute()
    {
        return $this->order_product->quantity - $this->quantity_reserved;
    }
}