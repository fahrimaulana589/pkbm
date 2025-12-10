<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pkbm_profile', function () {
            return \App\Models\PkbmProfile::first();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'App\Http\View\Composers\SidebarComposer');
        
        View::composer('*', function ($view) {
            $view->with('profile', app('pkbm_profile'));
        });
    }
}
