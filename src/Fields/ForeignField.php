<?php


namespace AlexVanVliet\Adminify\Fields;


use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Validation\Rule;

class ForeignField extends Field
{
    /**
     * Get the name of the view used for the form field.
     *
     * @return string
     */
    public function view(): string
    {
        return 'adminify::fields.foreign';
    }

    /**
     * Get the validation rules.
     *
     * @param EloquentModel|null $object The object being updated, if any.
     * @return array
     */
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

    /**
     * Get all the referenced objects.
     *
     * @return mixed
     */
    public function getReferenced()
    {
        $referenced_model = $this->field->getOptions()['references_model'];
        return $referenced_model::all();
    }
}
