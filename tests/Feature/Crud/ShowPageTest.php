<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class ShowPageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.show', ['model' => (new User())->getTable(), 'object' => $this->user]);
    }

    protected function request()
    {
        return $this->get($this->route());
    }

    /** @test */
    function the_show_page_displays_the_model()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Users');
    }

    /** @test */
    function the_show_page_displays_the_selected_user()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText($this->user->id);
        $response->assertSeeText($this->user->name);
        $response->assertSeeText($this->user->email);
    }

    /** @test */
    function the_show_page_displays_all_the_fields()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Id');
        $response->assertSeeText('Name');
        $response->assertSeeText('Email');
    }

    /** @test */
    function the_show_page_does_not_show_the_hidden_fields()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertDontSeeText('Password');
        $response->assertDontSeeText('Remember Token');
    }
}
