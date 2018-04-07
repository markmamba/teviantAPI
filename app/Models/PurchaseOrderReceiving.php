<?php

namespace App\Models;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceiving extends Model
{
    public function product()
    {
    	return $this->belongsTo('App\Models\PurchaseOrderProduct', 'product_id');
    }

    public function purchase_order()
    {
    	return $this->belongsTo('App\Models\PurchaseOrder');
    }
}
