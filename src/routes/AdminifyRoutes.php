<?php


namespace AlexVanVliet\Adminify\routes;


use AlexVanVliet\Adminify\Http\Controllers\Crud\CreateController as CrudCreateController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\IndexController as CrudIndexController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\StoreController as CrudStoreController;
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
        $router->get("/crud/{model}/create", CrudCreateController::class)->name('adminify.crud.create');
        $router->post("/crud/{model}", CrudStoreController::class)->name('adminify.crud.store');
        $router->getRoutes()->refreshNameLookups();
    }
}
