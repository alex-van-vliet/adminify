<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Validation\Rule;

class ForeignField extends Field
{
    public function view(): string
    {
        return 'adminify::fields.foreign';
    }

    public function rules(?EloquentModel $object = null): array
    {
        $referenced_model = $this->field->getOptions()['references_model'];
        /** @var EloquentModel $referenced_model */
        $referenced_model = new $referenced_model();
        return [
            'required',
            Rule::exists($referenced_model->getTable(), $referenced_model->getKeyName()),
        ];
    }

    public function value(mixed $value): string
    {
        return $value;
    }

    public function keepValue(mixed $value, ?EloquentModel $object = null): bool
    {
        return true;
    }

    public function getReferenced()
    {
        $referenced_model = $this->field->getOptions()['references_model'];
        return $referenced_model::all();
    }
}
