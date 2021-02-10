<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class IndexPageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.index', ['model' => (new User())->getTable()]);
    }

    protected function request()
    {
        return $this->get($this->route());
    }

    /** @test */
    function the_index_page_displays_the_model()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Users');
    }

    /** @test */
    function the_index_page_displays_all_the_users()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->admin)->request();

        foreach (User::all() as $user) {
            $response->assertSeeText($user->id);
            $response->assertSeeText($user->name);
            $response->assertSeeText($user->email);
        }
    }

    /** @test */
    function the_index_page_displays_all_the_fields()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->admin)->request();

        $response->assertSeeText('Id');
        $response->assertSeeText('Name');
        $response->assertSeeText('Email');
    }
}
