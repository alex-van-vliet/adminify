<?php


namespace AlexVanVliet\Adminify\Tests\Feature;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class IndexPageTest extends PageTest
{
    /** @test */
    function unauthenticated_users_are_forbidden()
    {
        $response = $this->get(route('adminify.index'));

        $response->assertForbidden();
    }

    /** @test */
    function non_admin_users_are_forbidden()
    {
        $response = $this->actingAs($this->user)->get(route('adminify.index'));

        $response->assertForbidden();
    }

    /** @test */
    function authenticated_users_can_see_the_index()
    {
        $response = $this->actingAs($this->admin)->get(route('adminify.index'));

        $response->assertSee($this->admin->name);
        $response->assertSee('Welcome on the admin panel!');
    }
}
