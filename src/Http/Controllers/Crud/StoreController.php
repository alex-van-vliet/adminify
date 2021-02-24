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
use Illuminate\Http\Request;
use ReflectionException;

class StoreController extends Controller
{
    /**
     * @param ModelTrait $model
     * @return Application|Factory|View
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     * @throws ReflectionException
     */
    public function __invoke(Request $request, $model)
    {
        $this->authorize('adminify.admin.crud.store', $model);

        $attribute = Model::from_attribute(get_class($model));

        $fields = $model->getAdminFields($attribute);

        $hiddenFields = $model->getAdminHiddenFields('store', $attribute);
        $fields = $fields->filter(fn($field) => !$hiddenFields->contains($field[1]))->values();

        $fields = $fields->map(fn($field) => array_merge($field, [Field::getField($field)]));

        $rules = $fields->mapWithKeys(fn($field) => [$field[1] => $field[3]->rules()]);

        $data = $this->validate($request, $rules->toArray());

        $model->create($data);

        return redirect()->route('adminify.crud.index', ['model' => $model->getTable()]);
    }
}