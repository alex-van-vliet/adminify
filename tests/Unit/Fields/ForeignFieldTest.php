<?php


namespace AlexVanVliet\Adminify\Tests\Unit\Fields;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\ForeignField;
use AlexVanVliet\Adminify\Tests\DatabaseTest;
use AlexVanVliet\Adminify\Tests\User;
use AlexVanVliet\Migratify\Fields\Field as MigratifyField;
use Illuminate\Validation\Rule;

class ForeignFieldTest extends DatabaseTest
{
    protected ForeignField $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = Field::getField('Author Id', 'author_id',
            new MigratifyField(MigratifyField::FOREIGN_ID, [], ['references_model' => User::class]));
    }

    /** @test */
    function it_creates_a_foreign_field()
    {
        $this->assertSame('Author Id', $this->field->getName());
        $this->assertSame('author_id', $this->field->getAccessor());
    }

    /** @test */
    function it_returns_the_correct_view()
    {
        $this->assertSame('adminify::fields.foreign', $this->field->view());
    }

    /** @test */
    function it_returns_the_same_value()
    {
        $this->assertSame('test', $this->field->value('test'));
    }

    /** @test */
    function it_can_get_all_the_referenced_objects()
    {
        $this->assertEquals(User::all(), $this->field->getReferenced());
    }

    /** @test */
    function it_is_required()
    {
        $this->assertSame('required', $this->field->rules()[0]);
    }

    /** @test */
    function it_must_exist_in_the_referenced_table()
    {
        $this->assertEquals(Rule::exists('users', 'id'), $this->field->rules()[1]);
    }
}
