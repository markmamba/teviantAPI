<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductReservation extends Model
{
	protected $fillable = [
		'order_product_id',
		'stock_id',
		'user_id',
		'quantity_reserved',
		'quantity_taken',
        'picked_at',
        'picked_by',
        'packed_at',
        'packed_by',
        'order_shipment_id'
	];

    public function order_product()
    {
    	return $this->belongsTo('App\Models\OrderProduct');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\OrderPackage');
    }

    public function stock()
    {
    	return $this->belongsTo('App\Models\InventoryStock');
    }

    public function picker()
    {
        return $this->belongsTo('App\User', 'picked_by');
    }

    public function packer()
    {
        return $this->belongsTo('App\User', 'packed_by');
    }    

    public function pickings()
    {
        return $this->hasMany('App\Models\OrderProductPicking', 'reservation_id');
    }

    /**
     * Get the deficiency of the reservation.
     * @return int
     */
    public function getDeficiencyAttribute()
    {
        return $this->order_product->quantity - $this->quantity_reserved;
    }

    public function getTotalPickedAttribute()
    {
        return $this->pickings->sum('quantity_picked');
    }

    public function scopeForPicking($query)
    {
        return $query->whereNull('picked_at');
    }

    public function scopeForPacking($query)
    {
        return $query->whereNotNull('picked_at')->whereNull('packed_at')->whereNull('packed_by');
    }
}
