<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\StringField;
use AlexVanVliet\Adminify\Tests\DatabaseTest;
use AlexVanVliet\Adminify\Tests\User;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;
use AlexVanVliet\Migratify\Model;
use Illuminate\Validation\Rule;

class UniqueStringFieldTest extends DatabaseTest
{
    protected StringField $field;

    public function setUp(): void
    {
        parent::setUp();

        $model = new Model(['name' => [MigratifyField::STRING, ['unique']]], ['id' => false, 'timestamps' => false]);
        $model->setModel(new User());
        $this->field = Field::getField('Name', 'name', $model->getFields()['name']);
    }

    /** @test */
    function it_creates_a_string_field()
    {
        $this->assertSame('Name', $this->field->getName());
        $this->assertSame('name', $this->field->getAccessor());
    }

    /** @test */
    function it_is_unique()
    {
        $this->assertTrue($this->field->isUnique());
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
    function it_has_a_unique_rule()
    {
        $this->assertContainsEquals(Rule::unique('users', 'name'), $this->field->rules());
    }

    /** @test */
    function it_has_a_unique_rule_with_ignore_on_update()
    {
        $this->assertContainsEquals(Rule::unique('users', 'name')->ignore($this->user->id, 'id'), $this->field->rules($this->user));
    }

    /** @test */
    function it_returns_the_same_value()
    {
        $this->assertSame('test', $this->field->value('test'));
    }

    /** @test */
    function it_is_kept()
    {
        $this->assertTrue($this->field->keepValue('test'));
        $this->assertTrue($this->field->keepValue(null));
        $this->assertTrue($this->field->keepValue('test', $this->user));
        $this->assertTrue($this->field->keepValue(null, $this->user));
    }
}
