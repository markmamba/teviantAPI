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
    	return $this->hasMany('App\Models\OrderProductReservation');
    }
}
