<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\StringField;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class EmailFieldTest extends TestCase
{
    protected StringField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Email', 'email', new MigratifyField(MigratifyField::STRING));
    }

    /** @test */
    public function it_creates_a_string_field()
    {
        $this->assertSame('Email', $this->field->getName());
        $this->assertSame('email', $this->field->getAccessor());
    }

    /** @test */
    public function it_is_an_email()
    {
        $this->assertTrue($this->field->isEmail());
    }

    /** @test */
    public function it_returns_the_correct_view()
    {
        $this->assertSame('adminify::fields.email', $this->field->view());
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
    function it_should_be_an_email()
    {
        $this->assertContains('email', $this->field->rules());
    }

    /** @test */
    function it_returns_the_same_value()
    {
        $this->assertSame('test', $this->field->value('test'));
    }
}
