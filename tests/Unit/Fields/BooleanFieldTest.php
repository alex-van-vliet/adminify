<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class BooleanFieldTest extends TestCase
{
    /** @test */
    function a_boolean_field_is_created_from_a_boolean_field()
    {
        $field = Field::getField('Admin', 'admin', new MigratifyField(MigratifyField::BOOLEAN));
        $this->assertSame('Admin', $field->getName());
        $this->assertSame('admin', $field->getAccessor());
    }

    /** @test */
    function the_boolean_field_returns_the_correct_view()
    {
        $field = Field::getField('Admin', 'admin', new MigratifyField(MigratifyField::BOOLEAN));
        $this->assertSame('adminify::fields.boolean', $field->view());
    }

    /** @test */
    function the_boolean_field_does_not_have_rules()
    {
        $field = Field::getField('Admin', 'admin', new MigratifyField(MigratifyField::BOOLEAN));
        $this->assertSame([], $field->rules());
    }
}
