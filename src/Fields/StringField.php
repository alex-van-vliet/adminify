<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Schema\Builder;

class StringField extends Field
{
    public function __toString(): string
    {
        $default = old($this->accessor);
        return <<<HTML
<div class="form-group">
    <label for="{$this->accessor}">{$this->name}</label>
    <input type="text" name="{$this->accessor}" class="form-control" id="{$this->accessor}" value="$default">
</div>
HTML;
    }

    public function rules(): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        return ['required', "max:$length"];
    }
}
