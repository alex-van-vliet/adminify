<?php


namespace AlexVanVliet\Adminify\Fields;


use AlexVanVliet\Migratify\Fields\Field as MigratifyField;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Field
{
    /**
     * Field constructor.
     * @param string $name The name of the field (as displayed to the user).
     * @param string $accessor The accessor to the field (as used in database).
     * @param MigratifyField $field The migratify field.
     */
    public function __construct(
        protected string $name,
        protected string $accessor,
        protected MigratifyField $field,
    )
    {
    }

    /**
     * @return string
     */
    public function getAccessor(): string
    {
        return $this->accessor;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MigratifyField
     */
    public function getModelField()
    {
        return $this->field;
    }

    /**
     * Get the correct field according to the type.
     *
     * @param string $name The name of the field (as displayed to the user).
     * @param string $accessor The accessor to the field (as used in database).
     * @param MigratifyField $field The migratify field.
     * @return static The form field.
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

    /**
     * Transform the value if necessary.
     *
     * @param mixed $value The value.
     * @return mixed
     */
    public function value(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Whether or not to keep the value.
     *
     * @param mixed $value The value.
     * @param EloquentModel|null $object The object being updated, if any.
     * @return bool
     */
    public function keepValue(mixed $value, ?EloquentModel $object = null): bool
    {
        return true;
    }

    /**
     * Get the name of the view used for the form field.
     *
     * @return string
     */
    abstract public function view(): string;

    /**
     * Get the validation rules.
     *
     * @param EloquentModel|null $object The object being updated, if any.
     * @return array
     */
    abstract public function rules(?EloquentModel $object = null): array;
}
