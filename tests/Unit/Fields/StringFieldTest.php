<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\StringField;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class StringFieldTest extends TestCase
{
    protected StringField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
    }

    /** @test */
    function it_creates_a_string_field()
    {
        $this->assertSame('Name', $this->field->getName());
        $this->assertSame('name', $this->field->getAccessor());
    }

    /** @test */
    function it_is_not_an_email()
    {
        $this->assertFalse($this->field->isEmail());
    }

    /** @test */
    function it_is_not_a_password()
    {
        $this->assertFalse($this->field->isPassword());
    }

    /** @test */
    function it_returns_the_correct_view()
    {
        $this->assertSame('adminify::fields.string', $this->field->view());
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
    function it_has_a_maximum_default_length()
    {
        $this->assertContains('max:255', $this->field->rules());
    }

    /** @test */
    function its_default_length_can_be_overriden()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING, ['length' => 12]));
        $this->assertContains('max:12', $field->rules());
    }

    /** @test */
    function it_returns_the_same_value()
    {
        $this->assertSame('test', $this->field->value('test'));
    }

    /** @test */
    function custom_rules_can_be_added()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING, [], [
            'adminify' => [
                'rules' => ['min:8'],
            ],
        ]));
        $this->assertContains('min:8', $field->rules());
    }
}
