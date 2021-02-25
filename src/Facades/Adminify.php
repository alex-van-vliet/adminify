<?php


namespace AlexVanVliet\Adminify\Facades;


use AlexVanVliet\Adminify\routes\AdminifyRoutes;
use Illuminate\Support\Facades\Facade;

class Adminify extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return AdminifyRoutes::class;
    }
}
