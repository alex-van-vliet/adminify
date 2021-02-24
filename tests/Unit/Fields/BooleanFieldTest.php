<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\BooleanField;
use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

class BooleanFieldTest extends TestCase
{
    protected BooleanField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Admin', 'admin', new MigratifyField(MigratifyField::BOOLEAN));
    }

    /** @test */
    public function it_creates_a_boolean_field()
    {
        $this->assertSame('Admin', $this->field->getName());
        $this->assertSame('admin', $this->field->getAccessor());
    }

    /** @test */
    public function it_returns_the_correct_view()
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
}
