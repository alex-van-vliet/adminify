<?php


namespace AlexVanVliet\Adminify\Tests;


use AlexVanVliet\Adminify\Facades\Adminify;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
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

        Adminify::routes($app->make('router'));

        require_once __DIR__ . '/database/migrations/2014_10_12_000000_create_users_table.php';
        require_once __DIR__ . '/../database/migrations/2021_02_10_000000_add_admin_field_to_users.php';

        (new \CreateUsersTable())->up();
        (new \AddAdminFieldToUsers())->up();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->user = User::factory()->create();
    }
}
