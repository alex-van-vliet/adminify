<?php


namespace AlexVanVliet\Adminify\Tests;


use AlexVanVliet\Adminify\Facades\Adminify;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the environment.
     *
     * @param Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        Adminify::routes($app->make('router'));

        require_once __DIR__ . '/database/migrations/2014_10_12_000000_create_users_table.php';

        (new \CreateUsersTable())->up();
    }

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }
}
