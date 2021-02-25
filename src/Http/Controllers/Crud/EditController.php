<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Fields\Field;
use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Adminify\ModelTrait;
use AlexVanVliet\Migratify\Model;
use AlexVanVliet\Migratify\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use ReflectionException;

class EditController extends Controller
{
    /**
     * @param ModelTrait $model
     * @param EloquentModel $object .
     * @return Application|Factory|View
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @throws ReflectionException
     */
    public function __invoke($model, $object)
    {
        $this->authorize('adminify.admin.crud.update', [$model, $object]);

        $attribute = Model::from_attribute(get_class($model));

        $fields = $model->getAdminFields($attribute);

        $hiddenFields = $model->getAdminHiddenFields('update', $attribute);
        $fields = $fields->filter(fn($field) => !$hiddenFields->contains($field[1]));

        $fields = $fields->map(fn($field) => Field::getField(...$field));

        return view('adminify::crud.edit', compact('attribute', 'object', 'fields', 'model'));
    }
}
