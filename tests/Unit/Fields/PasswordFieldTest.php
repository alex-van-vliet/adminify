<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\StringField;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;
use Illuminate\Support\Facades\Hash;

class PasswordFieldTest extends TestCase
{
    protected StringField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Password', 'password', new MigratifyField(MigratifyField::STRING));
    }

    /** @test */
    function it_creates_a_string_field()
    {
        $this->assertSame('Password', $this->field->getName());
        $this->assertSame('password', $this->field->getAccessor());
    }

    /** @test */
    function it_is_a_password()
    {
        $this->assertTrue($this->field->isPassword());
    }

    /** @test */
    function it_returns_the_correct_view()
    {
        $this->assertSame('adminify::fields.password', $this->field->view());
    }

    /** @test */
    function it_is_required()
    {
        $this->assertEquals('required', $this->field->rules()[0]);
    }

    /** @test */
    function it_is_a_string()
    {
        $this->assertEquals('string', $this->field->rules()[1]);
    }

    /** @test */
    function it_does_not_have_a_maximum_default_length()
    {
        $this->assertNotContains('max:255', $this->field->rules());
    }

    /** @test */
    function it_should_be_confirmed()
    {
        $this->assertContains('confirmed', $this->field->rules());
    }

    /** @test */
    function it_returns_the_hashed_value()
    {
        $this->assertTrue(Hash::check('test', $this->field->value('test')));
    }
}
