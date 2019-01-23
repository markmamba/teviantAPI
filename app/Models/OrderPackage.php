<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    protected $fillable = [
    	'order_id',
    	'sales_invoice_number',
    	'tracking_number',
    	'order_carrier_id',
    	'delivered_at',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order');
    }

    public function reservations()
    {
    	return $this->hasMany('App\Models\OrderProductReservation', 'order_package_id');
    }

    public function carrier()
    {
    	return $this->belongsTo('App\Models\OrderCarrier', 'order_carrier_id', 'id');
    }
}
