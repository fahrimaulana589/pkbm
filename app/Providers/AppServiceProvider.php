<?php

namespace App\Providers;

use App\Models\PkbmProfile;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Profile is now shared via ViewServiceProvider
            // Facades\View::share('profile', PkbmProfile::first());
            
            $setting = Setting::find(1);
            if ($setting) {
                config([
                    'mail.mailers.smtp.host' => $setting->email_server,
                    'mail.mailers.smtp.port' => $setting->email_port,
                    'mail.mailers.smtp.username' => $setting->email_username,
                    'mail.mailers.smtp.password' => $setting->email_password,
                ]);
            }
        } catch (\Exception $e) {
            // Ignore database errors during boot (e.g. migrations not run yet)
        }
    }
}
