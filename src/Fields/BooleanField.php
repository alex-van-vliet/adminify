<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Eloquent\Model as EloquentModel;

class BooleanField extends Field
{
    /**
     * Get the name of the view used for the form field.
     *
     * @return string
     */
    public function view(): string
    {
        return 'adminify::fields.boolean';
    }

    /**
     * Get the validation rules.
     *
     * @param EloquentModel|null $object The object being updated, if any.
     * @return array
     */
    public function rules(?EloquentModel $object = null): array
    {
        return [];
    }

    /**
     * Transform the value to boolean.
     *
     * @param mixed $value The value.
     * @return mixed
     */
    public function value(mixed $value): bool
    {
        return boolval($value);
    }
}
