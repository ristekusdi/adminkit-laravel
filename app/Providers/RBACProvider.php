<?php

namespace App\Providers;

use App\Services\RBAC;
use Illuminate\Support\ServiceProvider;

class RBACProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('rbac', function () {
            return new RBAC;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
