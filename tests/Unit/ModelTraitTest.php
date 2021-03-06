<?php


namespace AlexVanVliet\Adminify\Tests\Unit;


use AlexVanVliet\Adminify\ModelTrait as AdminifyModelTrait;
use AlexVanVliet\Adminify\Tests\TestCase;
use AlexVanVliet\Migratify\Fields\Field;
use AlexVanVliet\Migratify\Model as ModelAttribute;
use AlexVanVliet\Migratify\ModelTrait;
use Illuminate\Database\Eloquent\Model;

#[ModelAttribute([
    'my_field' => [Field::STRING],
])]
class ModelTraitTest_Base extends Model
{
    use ModelTrait, AdminifyModelTrait;
}

#[ModelAttribute([
], [
    'adminify' => ['title' => 'test'],
])]
class ModelTraitTest_Title extends Model
{
    use ModelTrait, AdminifyModelTrait;
}

#[ModelAttribute([
    'my_field' => [Field::STRING, [], ['adminify' => ['name' => 'test']]]
])]
class ModelTraitTest_Field extends Model
{
    use ModelTrait, AdminifyModelTrait;
}

#[ModelAttribute([
    'hidden_field' => [Field::STRING, [], ['adminify' => ['hidden' => ['index']]]],
    'shown_field' => [Field::STRING],
])]
class ModelTraitTest_Hidden extends Model
{
    use ModelTrait, AdminifyModelTrait;
}

class ModelTraitTest extends TestCase
{
    /** @test */
    function the_admin_title_has_a_default_value()
    {
        $this->assertEquals('Model Trait Test  Bases', (new ModelTraitTest_Base())->getAdminTitle());
    }

    /** @test */
    function the_admin_title_can_be_overwritten()
    {
        $this->assertEquals('tests', (new ModelTraitTest_Title())->getAdminTitle());
    }

    /** @test */
    function the_admin_title_can_be_retrieved_singularly()
    {
        $this->assertEquals('Model Trait Test  Base', (new ModelTraitTest_Base())->getAdminTitle(true));
    }

    /** @test */
    function the_admin_title_can_be_overwritten_and_retrieved_singularly()
    {
        $this->assertEquals('test', (new ModelTraitTest_Title())->getAdminTitle(true));
    }

    /** @test */
    function the_fields_names_have_a_default_value()
    {
        $this->assertEquals('My Field', (new ModelTraitTest_Base())->getAdminFieldName('my_field'));
    }

    /** @test */
    function the_fields_names_can_be_overwritten()
    {
        $this->assertEquals('test', (new ModelTraitTest_Field())->getAdminFieldName('my_field'));
    }

    /** @test */
    function the_hidden_fields_can_be_retrieved()
    {
        $this->assertEquals(['hidden_field'], (new ModelTraitTest_Hidden())->getAdminHiddenFields('index')->toArray());
    }
}
