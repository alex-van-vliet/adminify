<?php


namespace AlexVanVliet\Adminify\Fields;


class StringField extends Field
{
    public function __toString(): string
    {
        return <<<HTML
<div class="form-group">
    <label for="{$this->accessor}">{$this->name}</label>
    <input type="text" name="{$this->accessor}" class="form-control" id="{$this->accessor}">
</div>
HTML;
    }
}
