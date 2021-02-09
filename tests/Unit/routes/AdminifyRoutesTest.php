<?php


namespace AlexVanVliet\Adminify\Tests\Unit\routes;


use AlexVanVliet\Adminify\routes\AdminifyRoutes;
use AlexVanVliet\Adminify\Tests\TestCase;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;

class AdminifyRoutesTest extends TestCase
{
    protected AdminifyRoutes $routes;
    protected Router $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->routes = new AdminifyRoutes();
        $this->router = new Router(new Dispatcher());
    }

    /** @test */
    function main_page_is_registered()
    {
        $this->routes->routes($this->router);

        $this->assertNotNull($route = $this->router->getRoutes()->getByName('adminify.index'));
        $this->assertEquals('/', $route->uri());
    }
}
