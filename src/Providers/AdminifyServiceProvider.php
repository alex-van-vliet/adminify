<?php


namespace AlexVanVliet\Adminify\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AdminifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/adminify.php' => config_path('adminify.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/adminify.php', 'adminify');
    }
}
