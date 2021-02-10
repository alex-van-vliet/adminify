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

abstract class PageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User An admin user.
     */
    protected User $admin;

    /**
     * @var User A regular user.
     */
    protected User $user;

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

        require_once __DIR__ . '/database/migrations/2014_10_12_000000_create_users_table.php';

        (new \CreateUsersTable())->up();
        // Add admin field is automatically added.

        config(['migratify.models' => [User::class]]);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->user = User::factory()->create();
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

    /** @test */
    function admin_users_are_allowed()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertOk();
    }
}
