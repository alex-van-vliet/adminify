<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public function isUnique(): bool
    {
        return array_key_exists('unique', $this->field->getAttributes())
            or in_array('unique', $this->field->getAttributes());
    }

    public function view(): string
    {
        if ($this->isPassword())
            return 'adminify::fields.password';
        if ($this->isEmail())
            return 'adminify::fields.email';
        return 'adminify::fields.string';
    }

    public function rules(?EloquentModel $object = null): array
    {
        $length = $this->field->getAttributes()['length'] ?? Builder::$defaultStringLength;
        if ($this->isPassword() and !is_null($object))
            $rules = ['nullable', 'string'];
        else
            $rules = ['required', 'string'];
        if (!$this->isPassword())
            $rules [] = "max:$length";
        else
            $rules [] = 'confirmed';
        if ($this->isEmail())
            $rules [] = 'email';
        if ($this->isUnique()) {
            if (is_null($object)) {
                $rules [] = Rule::unique($this->field->getModel()->getModel()->getTable(), $this->accessor);
            } else {
                $rules [] = Rule::unique($this->field->getModel()->getModel()->getTable(), $this->accessor)->ignore($object->getKey(), $object->getKeyName());
            }
        }
        return array_merge($rules, $this->field->getOptions()['adminify']['rules'] ?? []);
    }

    public function value(mixed $value): string
    {
        if ($this->isPassword()) {
            return Hash::make($value);
        } else {
            return $value;
        }
    }

    public function keepValue(mixed $value, ?EloquentModel $object = null): bool
    {
        if ($this->isPassword() && !is_null($object) && is_null($value))
            return false;
        return true;
    }
}
