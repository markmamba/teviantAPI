<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\PurchaseOrder;
use App\Observers\OrderObserver;
use App\Observers\PurchaseOrderObserver;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Order::observe(OrderObserver::class);
        PurchaseOrder::observe(PurchaseOrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
