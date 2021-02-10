<?php


namespace AlexVanVliet\Adminify\Tests\Feature;


use AlexVanVliet\Adminify\Tests\PageTest;

class IndexPageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.index');
    }

    protected function request()
    {
        return $this->get($this->route());
    }

    /** @test */
    function authenticated_users_can_see_the_index()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSee($this->admin->name);
        $response->assertSee('Welcome on the admin panel!');
    }
}
