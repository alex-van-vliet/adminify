<?php


namespace AlexVanVliet\Adminify\Http\Controllers\Crud;


use AlexVanVliet\Adminify\Http\Controllers\Controller;
use AlexVanVliet\Migratify\Model;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    protected function getTitle($snake)
    {
        return Str::title(str_replace('_', ' ', $snake));
    }

    public function __invoke($model)
    {
        $this->authorize('adminify.admin.crud.index', $model);

        $attribute = Model::from_attribute(get_class($model));
        $objects = $model->all();

        $do_not_treat = [];
        if ($attribute->getOptions()['id']) {
            $do_not_treat['id'] = true;
        }
        if ($attribute->getOptions()['timestamps']) {
            $do_not_treat['created_at'] = true;
            $do_not_treat['updated_at'] = true;
        }
        if ($attribute->getOptions()['soft_deletes']) {
            $do_not_treat['deleted_at'] = true;
        }

        $fields = [];

        if ($attribute->getOptions()['id']) {
            $fields[] = ['Id', 'id', $attribute->getFields()['id']];
        }

        foreach ($attribute->getFields() as $name => $field) {
            if (!($do_not_treat[$name] ?? false)) {
                $fields[] = [$this->getTitle($name), $name, $field];
            }
        }

        if ($attribute->getOptions()['timestamps']) {
            $fields[] = ['Created At', 'created_at', $attribute->getFields()['created_at']];
            $fields[] = ['Updated At', 'updated_at', $attribute->getFields()['updated_at']];
        }
        if ($attribute->getOptions()['soft_deletes']) {
            $fields[] = ['Deleted At', 'deleted_at', $attribute->getFields()['deleted_at']];
        }

        return view('adminify::crud.index', compact('attribute', 'objects', 'fields') + [
                'title' => $this->getTitle($model->getTable()),
            ]);
    }
}
