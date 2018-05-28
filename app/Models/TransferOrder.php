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
		'aisle',
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

    public function scopeNotCompleted()
    {
    	return $this->whereNull('transferred_at');
    }

    public function scopeCompleted()
    {
    	return $this->whereNotNull('transferred_at');
    }

    public function getAisleRowBinAttribute()
    {
        return $this->aisle . '-' . $this->row . '-' . $this->bin;
    }
}
