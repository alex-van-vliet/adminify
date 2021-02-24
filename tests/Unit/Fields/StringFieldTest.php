<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class StringFieldTest extends TestCase
{
    /** @test */
    function a_string_field_is_created_from_a_string_field()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertSame('Name', $field->getName());
        $this->assertSame('name', $field->getAccessor());
    }

    /** @test */
    function the_string_field_returns_the_correct_view()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertSame('adminify::fields.string', $field->view());
    }

    /** @test */
    function the_string_field_is_required()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertEquals('required', $field->rules()[0]);
    }

    /** @test */
    function the_string_field_has_a_maximum_default_length()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertContains('max:255', $field->rules());
    }

    /** @test */
    function the_maximum_length_is_the_field_length_if_provided()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING, ['length' => 12]));
        $this->assertContains('max:12', $field->rules());
    }
}
