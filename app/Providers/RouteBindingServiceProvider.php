<?php

namespace App\Providers;
use App\Models\Product;
use App\Models\User;
use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteBindingServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider
     */
    public function boot()
    {
        // The binder instance
        $binder = $this->binder;

        $binder->bind('user', User::class);
        $binder->bind('product', Product::class);
    }

}
