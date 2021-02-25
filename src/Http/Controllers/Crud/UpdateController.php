<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Fields\BooleanField;
use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Fields\StringField;
use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Adminify\ModelTrait;
use AlexVanVliet\Migratify\Model;
use AlexVanVliet\Migratify\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ReflectionException;

class UpdateController extends Controller
{
    /**
     * @param ModelTrait $model
     * @param EloquentModel $object
     * @return Application|Factory|View
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     * @throws ReflectionException
     */
    public function __invoke(Request $request, $model, $object)
    {
        $this->authorize('adminify.admin.crud.update', [$model, $object]);

        $attribute = Model::from_attribute(get_class($model));

        $fields = $model->getAdminFields($attribute);

        $hiddenFields = $model->getAdminHiddenFields('update', $attribute);
        $fields = $fields->filter(fn($field) => !$hiddenFields->contains($field[1]))->values();

        $fields = $fields->map(fn($field) => Field::getField(...$field));

        $rules = $fields->mapWithKeys(fn($field) => [$field->getAccessor() => $field->rules($object)]);

        $data = $this->validate($request, $rules->toArray());

        $mappedFields = $fields->mapWithKeys(fn($field) => [$field->getAccessor() => $field]);

        foreach ($data as $k => $v) {
            if ($mappedFields[$k]->keepValue($v, $object))
                $data[$k] = $mappedFields[$k]->value($v, $object);
            else
                unset($data[$k]);
        }

        $object->update($data);

        return redirect()->route('adminify.crud.show', ['model' => $model->getTable(),
            'object' => $object->getKey()]);
    }
}
