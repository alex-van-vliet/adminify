<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Adminify\ModelTrait;
use AlexVanVliet\Migratify\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use ReflectionException;

class DestroyController extends Controller
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
        $this->authorize('adminify.admin.crud.destroy', [$model, $object]);

        $object->delete();

        return redirect()->route('adminify.crud.index', ['model' => $model->getTable()]);
    }
}
