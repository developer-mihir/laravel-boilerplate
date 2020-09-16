<?php

namespace App\Providers\Custom;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Interfaces\CarsInterface', 'App\Repositories\CarsRepository');
        $this->app->bind('App\Interfaces\UsersInterface', 'App\Repositories\UsersRepository');
    }
}
