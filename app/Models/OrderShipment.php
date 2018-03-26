<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
	protected $fillable = [
		'order_id',
		'package_length',
		'package_width',
		'package_height',
		'package_weight',
	];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
