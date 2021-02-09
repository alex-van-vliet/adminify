<?php


namespace AlexVanVliet\Adminify\routes;


use Illuminate\Routing\Router;

class AdminifyRoutes
{
    /**
     * Register all the necessary routes
     *
     * @param Router|null $router The router.
     */
    public function routes(?Router $router): void
    {
        if (is_null($router))
            $router = app()->make('router');
        $router->get('/', fn() => 'hi')->name('adminify.index');
        $router->getRoutes()->refreshNameLookups();
    }
}
