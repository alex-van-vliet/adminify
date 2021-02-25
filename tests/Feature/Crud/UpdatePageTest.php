<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;
use Illuminate\Support\Facades\Hash;

class UpdatePageTest extends PageTest
{
    protected $originalUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->originalUser = User::factory()->create([
            'name' => 'Original',
            'email' => 'original@localhost',
            'password' => Hash::make('original pwd'),
        ])->fresh();
    }

    protected function route()
    {
        return route('adminify.crud.update', ['model' => (new User())->getTable(), 'object' => $this->originalUser]);
    }

    protected function request($data = null)
    {
        return $this->from(route('adminify.crud.edit', ['model' => (new User())->getTable(), 'object' => $this->originalUser]))
            ->put($this->route(), $data ?? []);
    }

    /** @test */
    function the_update_page_updates_the_fields()
    {
        $this->assertCount(3, User::all());

        $response = $this->actingAs($this->admin)->request([
            'name' => 'Updated',
            'email' => 'updated@localhost',
            'password' => 'updated pwd',
            'password_confirmation' => 'updated pwd',
        ]);

        $this->assertCount(3, User::all());
        $user = User::find($this->originalUser->getKey());
        $this->assertSame('Updated', $user->name);
        $this->assertSame('updated@localhost', $user->email);
        $this->assertTrue(Hash::check('updated pwd', $user->password));

        $response
            ->assertRedirect(route('adminify.crud.show', ['model' => (new User())->getTable(),
                'object' => $user->getKey()]))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    function the_update_page_validates_the_data()
    {
        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'updated@localhost',
            'password' => 'updated pwd',
            'password_confirmation' => 'updated pwd',
        ]);
        $response
            ->assertRedirect(route('adminify.crud.edit', ['model' => (new User())->getTable(), 'object' => $this->originalUser]))
            ->assertSessionHasErrors('name');

        $this->assertEquals($this->originalUser, User::find($this->originalUser->getKey()));
    }

    /** @test */
    function the_data_is_set_as_old_input()
    {
        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'updated@localhost',
            'password' => 'updated pwd',
            'password_confirmation' => 'updated pwd',
        ]);
        $response
            ->assertRedirect(route('adminify.crud.edit', ['model' => (new User())->getTable(), 'object' => $this->originalUser]))
            ->assertSessionHasInput('email', 'updated@localhost');

        $this->assertEquals($this->originalUser, User::find($this->originalUser->getKey()));
    }


    /** @test */
    function the_password_is_not_set_as_old_input()
    {
        $response = $this->actingAs($this->admin)->request([
            'name' => '',
            'email' => 'updated@localhost',
            'password' => 'updated pwd',
            'password_confirmation' => 'updated pwd',
        ]);
        $response->assertSessionHasErrors('name')
            ->assertSessionMissing('_old_input.password');
    }
}
