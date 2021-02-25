<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Eloquent\Model as EloquentModel;

class BooleanField extends Field
{
    public function view(): string
    {
        return 'adminify::fields.boolean';
    }

    public function rules(?EloquentModel $object = null): array
    {
        return [];
    }

    public function value(mixed $value, ?EloquentModel $object = null): bool
    {
        return boolval($value);
    }

    public function keepValue(mixed $value, ?EloquentModel $object = null): bool
    {
        return true;
    }
}
