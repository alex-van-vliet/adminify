<?php


namespace AlexVanVliet\Adminify\Tests;


use AlexVanVliet\Adminify\Facades\Adminify;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

abstract class PageTest extends DatabaseTest
{
    /**
     * Setup the environment.
     *
     * @param Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make('router')->group(['middleware' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]], function ($router) {
            Adminify::routes($router);
        });
    }

    abstract protected function route();

    abstract protected function request();

    /** @test */
    function unauthenticated_users_are_forbidden()
    {
        $response = $this->request();

        $response->assertForbidden();
    }

    /** @test */
    function non_admin_users_are_forbidden()
    {
        $response = $this->actingAs($this->user)->request();

        $response->assertForbidden();
    }
}
