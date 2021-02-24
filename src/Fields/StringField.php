<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Schema\Builder;

class StringField extends Field
{
    public function view(): string
    {
        return 'adminify::fields.string';
    }

    public function rules(): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        return ['required', "max:$length"];
    }
}
