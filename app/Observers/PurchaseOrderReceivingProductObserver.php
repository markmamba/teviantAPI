<?php

namespace App\Observers;

use App\Models\PurchaseOrderReceivingProduct;

class PurchaseOrderReceivingProductObserver
{
    public function __construct()
    {
        // 
    }

    public function created(PurchaseOrderReceivingProduct $purchase_order_receiving_product)
    {
        // Check and mark the Purchase Order as completed if all of its products are fulfilled.
        if ($purchase_order_receiving_product->product->purchase_order->products()->sum('quantity') == $purchase_order_receiving_product->product->purchase_order->receiving_products()->sum('purchase_order_receiving_products.quantity')) {
            $purchase_order_receiving_product->product->purchase_order->update(['completed_at' => \Carbon\Carbon::now()]);
        }
    }
}
