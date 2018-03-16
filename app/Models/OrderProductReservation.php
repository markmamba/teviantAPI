<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductReservation extends Model
{
    public function order_product()
    {
    	return $this->belongsTo('App\Models\OrderProduct');
    }
}
