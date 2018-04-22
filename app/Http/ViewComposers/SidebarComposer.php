<?php

namespace App\Http\ViewComposers;

use App\Models\Order;
use App\Models\PurchaseOrder;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    public function __construct()
    {
    	// 
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
    	// Share the number of incomplete orders to the specified view.
        $view->with('orders_incomplete_count', Order::incomplete()->count());
        $view->with('purchase_orders_incomplete_count', PurchaseOrder::notCompleted()->count());
    }
}