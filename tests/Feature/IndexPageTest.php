<?php


namespace AlexVanVliet\Adminify\Tests\Feature;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class IndexPageTest extends PageTest
{
    /** @test */
    function unauthenticated_users_are_redirected()
    {
        $response = $this->get(route('adminify.index'));

        $response->assertForbidden();
    }

    /** @test */
    function authenticated_users_can_see_the_index()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get(route('adminify.index'));

        $response->assertSee($user->name);
        $response->assertSee('Welcome on the admin panel!');
    }
}
