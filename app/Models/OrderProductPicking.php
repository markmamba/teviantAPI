<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductPicking extends Model
{
    public function reservation()
    {
    	return $this->belongsTo('App\Models\OrderProductReservation', 'reservation_id');
    }

    public function picker()
    {
        return $this->belongsTo('App\User', 'picker_id');
    }

	public function movement()
    {
        return $this->belongsTo('App\Models\InventoryStockMovement', 'movement_id');
    }    
}
