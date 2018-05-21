<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class TransferOrder extends Model
{
	use CrudTrait;

	protected $fillable = [
		'purchase_order_receiving_product_id',
		'location_id',
		'ailse',
		'row',
		'bin',
		'quantity',
		'remark',
	];

    public function purchase_order_receiving_product()
    {
    	return $this->belongsTo('App\Models\PurchaseOrderReceivingProduct');
    }

    public function location()
    {
    	return $this->belongsTo('App\Models\Location');	
    }
}
