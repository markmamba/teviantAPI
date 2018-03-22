<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{ 
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'backpack::inc.sidebar', 'App\Http\ViewComposers\SidebarComposer'
        );

        // Using Closure based composers...
        // View::composer('backpack::inc.sidebar', function ($view) {
        //     $view->with('orders_count', Order::count());
        // });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}