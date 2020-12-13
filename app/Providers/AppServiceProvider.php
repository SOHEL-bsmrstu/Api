<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\LumenServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(LumenServiceProvider::class);
        $this->app->register(RouteBindingServiceProvider::class);

        $this->app['auth']->viaRequest('api', function ($request)
        {
            return User::where('email', $request->input('email'))->first();
        });
    }
}
