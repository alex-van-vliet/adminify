<?php


namespace AlexVanVliet\Adminify\routes;


use AlexVanVliet\Adminify\Http\Controllers\Crud\IndexController as CrudIndexController;
use AlexVanVliet\Adminify\Http\Controllers\IndexController;
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
        $router->get('/', IndexController::class)->name('adminify.index');
        $router->get("/crud/{model}", CrudIndexController::class)->name('adminify.crud.index');
        $router->getRoutes()->refreshNameLookups();
    }
}
