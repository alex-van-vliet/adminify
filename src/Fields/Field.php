<?php


namespace AlexVanVliet\Adminify\Fields;


use AlexVanVliet\Migratify\Fields\Field as MigratifyField;

abstract class Field
{
    public function __construct(
        protected string $name,
        protected string $accessor,
        protected MigratifyField $field,
    )
    {
    }

    /**
     * @param [string, string, MigratifyField] $field
     * @return static
     */
    public static function getField($field): static
    {
        [$name, $accessor, $field] = $field;
        /** @var MigratifyField $field */

        $formFieldClass = [
            MigratifyField::STRING => StringField::class,
        ][$field->getType()];

        return new $formFieldClass($name, $accessor, $field);
    }

    abstract public function __toString(): string;
}
