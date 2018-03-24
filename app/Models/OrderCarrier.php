<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCarrier extends Model
{
    protected $fillable = [
    	'order_id',
    	'name',
    	'price',
    	'delivery_text',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order');
    }
}
