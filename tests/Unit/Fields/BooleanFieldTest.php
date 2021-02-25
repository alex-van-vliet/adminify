<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\BooleanField;
use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Tests\DatabaseTest;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class BooleanFieldTest extends DatabaseTest
{
    protected BooleanField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Admin', 'admin', new MigratifyField(MigratifyField::BOOLEAN));
    }

    /** @test */
    function it_creates_a_boolean_field()
    {
        $this->assertSame('Admin', $this->field->getName());
        $this->assertSame('admin', $this->field->getAccessor());
    }

    /** @test */
    function it_returns_the_correct_view()
    {
        $this->assertSame('adminify::fields.boolean', $this->field->view());
    }

    /** @test */
    function it_has_no_rules()
    {
        $this->assertEmpty($this->field->rules());
    }

    /** @test */
    function it_returns_the_boolean_value()
    {
        $this->assertTrue($this->field->value('1'));
        $this->assertFalse($this->field->value('0'));
        $this->assertFalse($this->field->value(null));
    }

    /** @test */
    function it_is_kept()
    {
        $this->assertTrue($this->field->keepValue('1'));
        $this->assertTrue($this->field->keepValue('0'));
        $this->assertTrue($this->field->keepValue(null));
        $this->assertTrue($this->field->keepValue('1', $this->user));
        $this->assertTrue($this->field->keepValue('0', $this->user));
        $this->assertTrue($this->field->keepValue(null, $this->user));
    }
}
