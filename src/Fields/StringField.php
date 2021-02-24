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

    public function isPassword(): bool
    {
        return Str::contains($this->accessor, 'password');
    }

    public function view(): string
    {
        if ($this->isPassword())
            return 'adminify::fields.password';
        if ($this->isEmail())
            return 'adminify::fields.email';
        return 'adminify::fields.string';
    }

    public function rules(): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        $rules = ['required', 'string'];
        if (!$this->isPassword())
            $rules [] = "max:$length";
        else
            $rules [] = 'confirmed';
        if ($this->isEmail())
            $rules [] = 'email';
        return $rules;
    }
}
