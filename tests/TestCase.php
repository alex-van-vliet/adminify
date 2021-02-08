<?php


namespace AlexVanVliet\Adminify\Tests;


use AlexVanVliet\Adminify\Providers\AdminifyServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Setup the environment.
     *
     * @param Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
    }

    /**
     * Setup the test.
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get the service providers from the package.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AdminifyServiceProvider::class,
        ];
    }
}
