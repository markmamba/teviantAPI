<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceivingProduct extends Model
{
    protected $fillable = [
    	'purchase_order_id',
    	'purchase_order_product_id',
    	'quantity',
    	'receiver_id',
    ];

    public function receiving()
    {
    	return $this->belongsTo('App\Models\PurchaseOrderReceiving', 'purchase_order_receiving_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\PurchaseOrderProduct', 'purchase_order_product_id');
    }

    public function transfer_orders()
    {
        return $this->hasMany('App\Models\TransferOrder');
    }

    /**
     * Get the quantity_transferrable attribute of the item.
     * @return int
     */
    public function getQuantityTransferrableAttribute()
    {
        return $this->product->quantity_received - $this->transfer_orders()->sum('quantity');
    }

    /**
     * Get the total quantity transferrable for the group of products.
     * @return int
     */
    public static function getProductQuantityTransferrable($product_id)
    {
        $purchase_order_receiving_product = PurchaseOrderReceivingProduct::find($product_id);

        $product_quantity_received = $purchase_order_receiving_product->product->quantity_received;
        $product_group_transferrable = PurchaseOrderReceivingProduct::whereHas('product', function($query) use ($product_id){
                $query->where('product_id', $product_id);
                $query->whereNull('completed_at');
            })
            ->doesntHave('transfer_orders')
            ->sum('quantity');
        $transferrable = 0;

        // dd($product_quantity_received, $product_group_transferrable);

        if ($product_quantity_received == $product_group_transferrable)
            $transferrable = $product_group_transferrable;
        if ($product_quantity_received > $product_group_transferrable)
            $transferrable = $product_group_transferrable;
        if ($product_quantity_received < $product_group_transferrable)
            $transferrable = $product_group_transferrable;

        // dd($transferrable);
        return $transferrable;
    }
}
