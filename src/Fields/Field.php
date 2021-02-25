<?php


namespace AlexVanVliet\Adminify\Fields;


use AlexVanVliet\Migratify\Fields\Field as MigratifyField;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Field
{
    public function __construct(
        protected string $name,
        protected string $accessor,
        protected MigratifyField $field,
    )
    {
    }

    public function getAccessor(): string
    {
        return $this->accessor;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name The name.
     * @param string $accessor The accessor.
     * @param MigratifyField $field The field.
     * @return static
     */
    public static function getField($name, $accessor, $field): static
    {
        $formFieldClass = [
            MigratifyField::STRING => StringField::class,

            MigratifyField::BOOLEAN => BooleanField::class,

            MigratifyField::FOREIGN_ID => ForeignField::class,
        ][$field->getType()];

        return new $formFieldClass($name, $accessor, $field);
    }

    public function getModelField()
    {
        return $this->field;
    }

    abstract public function view(): string;

    abstract public function rules(?EloquentModel $object = null): array;

    abstract public function value(mixed $value): mixed;
    abstract public function keepValue(mixed $value, ?EloquentModel $object = null): bool;
}
