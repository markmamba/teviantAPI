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
        'delivered_at',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Models\Order');
    }

    public function packages()
    {
        return $this->hasOne('App\Models\OrderPackage');
    }
}
