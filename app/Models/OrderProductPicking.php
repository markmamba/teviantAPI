<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductPicking extends Model
{
    public function reservation()
    {
    	return $this->belongsTo('App\Models\OrderProductReservation', 'reservation_id');
    }
}
