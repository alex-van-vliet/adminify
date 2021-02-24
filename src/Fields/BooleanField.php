<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BooleanField extends Field
{
    public function view(): string
    {
        return 'adminify::fields.boolean';
    }

    public function rules(): array
    {
        return [];
    }

    public function value(mixed $value): bool
    {
        return boolval($value);
    }
}
