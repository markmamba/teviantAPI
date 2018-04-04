<?php

namespace App\Observers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderObserver
{
    public function creating(PurchaseOrder $purchase_order)
    {
        // Auto set the current user as the creator of the purchase order record.
        $purchase_order->user_id = \Auth::user()->id;
    }
}
