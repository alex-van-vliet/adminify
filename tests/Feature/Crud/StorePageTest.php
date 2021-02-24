<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class StorePageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.store', ['model' => (new User())->getTable()]);
    }

    protected function request($data = null)
    {
        return $this->from(route('adminify.crud.create', ['model' => (new User())->getTable()]))
            ->post($this->route(), $data ?? []);
    }

    /** @test */
    function the_store_page_creates_a_new_entity()
    {
        $this->assertNull(User::where('email', 'test@localhost')->first());

        $response = $this->actingAs($this->admin)->request([
            'name' => 'Test Name',
            'email' => 'test@localhost',
            'password' => 'password',
        ]);
        $response
            ->assertRedirect(route('adminify.crud.index', ['model' => (new User())->getTable()]))
            ->assertSessionHasNoErrors();

        $user = User::where('email', 'test@localhost')->first();
        $this->assertNotNull($user);
        $this->assertSame('Test Name', $user->name);
        $this->assertSame('test@localhost', $user->email);
        $this->assertSame('password', $user->password);
    }

    /** @test */
    function the_store_page_validates_the_data()
    {
        $this->assertNull(User::where('email', 'test@localhost')->first());

        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'test@localhost',
            'password' => 'password',
        ]);
        $response
            ->assertRedirect(route('adminify.crud.create', ['model' => (new User())->getTable()]))
            ->assertSessionHasErrors('name');

        $this->assertNull(User::where('email', 'test@localhost')->first());
    }

    /** @test */
    function the_data_is_set_as_old_input()
    {
        $this->assertNull(User::where('email', 'test@localhost')->first());

        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'test@localhost',
            'password' => 'password',
        ]);
        $response
            ->assertRedirect(route('adminify.crud.create', ['model' => (new User())->getTable()]))
            ->assertSessionHasInput('email', 'test@localhost');

        $this->assertNull(User::where('email', 'test@localhost')->first());
    }


    /** @test */
    function the_password_is_not_set_as_old_input()
    {
        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'test@localhost',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('name')
            ->assertSessionMissing('_old_input.password');
    }
}
