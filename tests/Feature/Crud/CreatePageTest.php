<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class CreatePageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.create', ['model' => (new User())->getTable()]);
    }

    protected function request()
    {
        return $this->get($this->route());
    }

    /** @test */
    function the_create_page_displays_the_model()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('User');
    }

    /** @test */
    function the_create_page_displays_all_the_fields()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Admin');
        $response->assertSeeText('Name');
        $response->assertSeeText('Email');
        $response->assertSeeText('Password');
    }

    /** @test */
    function the_create_page_does_not_show_the_hidden_fields()
    {
        $response = $this->actingAs($this->admin)->request();

        $response->assertDontSeeText('Id');
        $response->assertDontSeeText('Email Verified At');
        $response->assertDontSeeText('Remember Token');
        $response->assertDontSeeText('Created At');
        $response->assertDontSeeText('Updated At');
    }
}
