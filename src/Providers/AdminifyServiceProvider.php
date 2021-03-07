<?php


namespace AlexVanVliet\Adminify\Providers;

use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminify');
        if ($this->app->runningInConsole()) {
            // Publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/adminify'),
            ], 'views');
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('adminify'),
            ], 'assets');
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Gate::define('adminify.admin.index', fn($user) => boolval($user->admin));
        Gate::define('adminify.admin.crud.index', fn($user, $model) => boolval($user->admin));
        Gate::define('adminify.admin.crud.store', fn($user, $model) => boolval($user->admin));
        Gate::define('adminify.admin.crud.show', fn($user, $model, $object) => boolval($user->admin));
        Gate::define('adminify.admin.crud.destroy', fn($user, $model, $object) => boolval($user->admin));
        Gate::define('adminify.admin.crud.update', fn($user, $model, $object) => boolval($user->admin));

        Route::bind('model', function ($value) {
            foreach (config('migratify.models') as $model) {
                $model = new $model();
                if ($value === $model->getTable()) {
                    return $model;
                }
            }
            throw new RecordsNotFoundException();
        });

        Route::bind('object', function ($value) {
            return request()->route()->model->find($value);
        });

        View::composer('adminify::sidebar', function ($view) {
            $links = [];
            foreach (config('migratify.models') as $model) {
                $model = new $model();
                $links[] = [$model->getCrudIndex(), $model->getAdminTitle()];
            }
            return $view->with('links', $links);
        });
    }
}
