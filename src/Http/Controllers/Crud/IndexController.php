<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Migratify\Model;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function __invoke($model)
    {
        $this->authorize('adminify.admin.crud.index', $model);

        $attribute = Model::from_attribute(get_class($model));
        $objects = $model->all();

        $fields = $model->getAdminFields($attribute);

        return view('adminify::crud.index', compact('attribute', 'objects', 'fields', 'model'));
    }
}
