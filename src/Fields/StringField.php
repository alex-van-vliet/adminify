<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Str;

class StringField extends Field
{
    public function isEmail(): bool
    {
        return Str::contains($this->accessor, 'email');
    }

    public function view(): string
    {
        if ($this->isEmail())
            return 'adminify::fields.email';
        return 'adminify::fields.string';
    }

    public function rules(): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        $rules = ['required', "max:$length"];
        if ($this->isEmail())
            $rules [] = 'email';
        return $rules;
    }
}
