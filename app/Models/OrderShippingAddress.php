<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShippingAddress extends Model
{
    public function order()
    {
    	return $this->belongsTo('App\Models\Order');
    }
}