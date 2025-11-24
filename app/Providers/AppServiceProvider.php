<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

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
        $setting = Setting::find(1);
        if ($setting) {
            config([
                'mail.mailers.smtp.host' => $setting->email_server,
                'mail.mailers.smtp.port' => $setting->email_port,
                'mail.mailers.smtp.username' => $setting->email_username,
                'mail.mailers.smtp.password' => $setting->email_password,
            ]);
        }
    }
}
