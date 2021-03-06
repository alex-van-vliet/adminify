<?php


namespace AlexVanVliet\Adminify\routes;


use AlexVanVliet\Adminify\Http\Controllers\Crud\CreateController as CrudCreateController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\DeleteController as CrudDeleteController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\DestroyController as CrudDestroyController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\EditController as CrudEditController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\IndexController as CrudIndexController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\ShowController as CrudShowController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\StoreController as CrudStoreController;
use AlexVanVliet\Adminify\Http\Controllers\Crud\UpdateController as CrudUpdateController;
use AlexVanVliet\Adminify\Http\Controllers\IndexController;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;

class AdminifyRoutes
{
    /**
     * Register all the necessary routes
     *
     * @param Router|null $router The router.
     * @throws BindingResolutionException
     */
    public function routes(?Router $router): void
    {
        if (is_null($router))
            $router = app()->make('router');
        $router->get('/', IndexController::class)->name('adminify.index');
        $router->get("/crud/{model}", CrudIndexController::class)->name('adminify.crud.index');
        $router->get("/crud/{model}/create", CrudCreateController::class)->name('adminify.crud.create');
        $router->post("/crud/{model}", CrudStoreController::class)->name('adminify.crud.store');
        $router->get("/crud/{model}/{object}", CrudShowController::class)->name('adminify.crud.show');
        $router->get("/crud/{model}/{object}/delete", CrudDeleteController::class)->name('adminify.crud.delete');
        $router->delete("/crud/{model}/{object}", CrudDestroyController::class)->name('adminify.crud.destroy');
        $router->get("/crud/{model}/{object}/edit", CrudEditController::class)->name('adminify.crud.edit');
        $router->put("/crud/{model}/{object}", CrudUpdateController::class)->name('adminify.crud.update');
        $router->getRoutes()->refreshNameLookups();
    }
}
