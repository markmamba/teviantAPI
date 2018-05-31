<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public function order()
    {
    	return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
    	return $this->belongsTo('App\Models\Inventory', 'product_id');
    }

    public function reservations()
    {
    	return $this->hasMany('App\Models\OrderProductReservation', 'order_product_id');
    }

    public function isFullyReserved()
    {
        if ($this->quantity == $this->quantity_reserved)
            return true;
        else
            return false;
    }

    public function getQuantityReservedAttribute()
    {
        return $this->reservations()->sum('quantity_reserved');
    }

    /**
     * Scope a query to only include Order Products that are not yet fullfilled.
     */
    public function scopePending($query)
    {
        return $query->doesntHave('reservations')->orWhereHas('reservations', function ($query) {
            $query->where('order_products.quantity', '!=', \DB::raw('order_product_reservations.quantity_reserved'));
        });
    }
}
