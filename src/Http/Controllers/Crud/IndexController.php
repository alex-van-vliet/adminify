<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Adminify\ModelTrait;
use AlexVanVliet\Migratify\Model;
use AlexVanVliet\Migratify\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use ReflectionException;

class IndexController extends Controller
{
    /**
     * @param ModelTrait $model
     * @return Application|Factory|View
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     * @throws ReflectionException
     */
    public function __invoke($model)
    {
        $this->authorize('adminify.admin.crud.index', $model);

        $attribute = Model::from_attribute(get_class($model));
        $objects = $model->all();

        $fields = $model->getAdminFields($attribute);

        $hiddenFields = $model->getAdminHiddenFields('index', $attribute);
        $fields = $fields->filter(fn($field) => !$hiddenFields->contains($field[1]));

        return view('adminify::crud.index', compact('attribute', 'objects', 'fields', 'model'));
    }
}
