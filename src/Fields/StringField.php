<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Str;

class StringField extends Field
{
    public function view(): string
    {
        return 'adminify::fields.string';
    }

    public function rules(): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        $rules = ['required', "max:$length"];
        if (Str::contains($this->accessor, 'email'))
            $rules [] = 'email';
        return $rules;
    }
}
