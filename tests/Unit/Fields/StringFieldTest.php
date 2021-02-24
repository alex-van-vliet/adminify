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
    function the_string_field_returns_the_correct_view_if_the_accessor_contains_email()
    {
        $field = Field::getField('Email', 'email', new MigratifyField(MigratifyField::STRING));
        $this->assertSame('adminify::fields.email', $field->view());
    }

    /** @test */
    function the_string_field_returns_the_correct_view_if_the_accessor_contains_password()
    {
        $field = Field::getField('Password', 'password', new MigratifyField(MigratifyField::STRING));
        $this->assertSame('adminify::fields.password', $field->view());
    }

    /** @test */
    function the_string_field_is_required()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertEquals('required', $field->rules()[0]);
    }

    /** @test */
    function the_string_field_is_a_string()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertEquals('string', $field->rules()[1]);
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

    /** @test */
    function a_field_should_not_be_an_email()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertNotContains('email', $field->rules());
    }

    /** @test */
    function a_field_should_not_be_confirmed()
    {
        $field = Field::getField('Name', 'name', new MigratifyField(MigratifyField::STRING));
        $this->assertNotContains('confirmed', $field->rules());
    }

    /** @test */
    function an_accessor_containing_email_should_be_an_email()
    {
        $field = Field::getField('Email', 'email', new MigratifyField(MigratifyField::STRING));
        $this->assertContains('email', $field->rules());
    }

    /** @test */
    function an_accessor_containing_password_should_be_confirmed()
    {
        $field = Field::getField('Password', 'password', new MigratifyField(MigratifyField::STRING));
        $this->assertContains('confirmed', $field->rules());
    }
}
