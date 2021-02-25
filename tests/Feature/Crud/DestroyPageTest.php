<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class DestroyPageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.destroy', ['model' => (new User())->getTable(), 'object' => $this->user]);
    }

    protected function request()
    {
        return $this->delete($this->route());
    }

    /** @test */
    function the_destroy_page_deletes_the_entity()
    {
        $this->assertCount(2, User::all());

        $response = $this->actingAs($this->admin)->request();
        $response
            ->assertRedirect(route('adminify.crud.index', ['model' => (new User())->getTable()]));

        $this->assertCount(1, User::all());
    }
}
