<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProductReceiving extends Model
{
    public function product()
    {
    	return $this->belongsTo('App\Models\PurchaseOrderProduct', 'product_id');
    }
}
