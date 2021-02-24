<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class DeletePageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.delete', ['model' => (new User())->getTable(), 'object' => $this->user]);
    }

    protected function request()
    {
        return $this->get($this->route());
    }

    /** @test */
    function the_delete_page_displays_the_model()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('User');
    }

    /** @test */
    function the_delete_page_displays_the_selected_user_id()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText($this->user->id);
    }

    /** @test */
    function the_delete_page_displays_a_confirmation_button()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Delete');
    }

    /** @test */
    function the_delete_page_displays_a_go_back_button()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Go back');
    }
}
