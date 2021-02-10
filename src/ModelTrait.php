<?php


namespace AlexVanVliet\Adminify;


use AlexVanVliet\Migratify\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

function snakeToTitle(string $snake): string
{
    return Str::title(str_replace('_', ' ', $snake));
}

trait ModelTrait
{
    public function getAdminTitle(bool $singular = false, ?Model $attribute = null): string
    {
        if (is_null($attribute)) {
            $attribute = Model::from_attribute(self::class);
        }

        $s = $attribute->getOptions()['adminify']['title'] ?? snakeToTitle(Str::singular($this->getTable()));
        if ($singular)
            return $s;
        else
            return Str::plural($s);
    }

    public function getAdminFieldName($field, ?Model $attribute = null): string
    {
        if (is_null($attribute)) {
            $attribute = Model::from_attribute(self::class);
        }

        return $attribute->getOptions()['adminify']['fields'][$field]['name'] ?? snakeToTitle($field);
    }

    public function getAdminFields(?Model $attribute = null): Collection
    {
        if (is_null($attribute)) {
            $attribute = Model::from_attribute(self::class);
        }

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
            $fields[] = [$this->getAdminFieldName('id'), 'id', $attribute->getFields()['id']];
        }

        foreach ($attribute->getFields() as $name => $field) {
            if (!($do_not_treat[$name] ?? false)) {
                $fields[] = [$this->getAdminFieldName($name), $name, $field];
            }
        }

        if ($attribute->getOptions()['timestamps']) {
            $fields[] = [$this->getAdminFieldName('created_at'), 'created_at', $attribute->getFields()['created_at']];
            $fields[] = [$this->getAdminFieldName('updated_at'), 'updated_at', $attribute->getFields()['updated_at']];
        }
        if ($attribute->getOptions()['soft_deletes']) {
            $fields[] = [$this->getAdminFieldName('deleted_at'), 'deleted_at', $attribute->getFields()['deleted_at']];
        }

        return collect($fields);
    }

    public function getAdminFieldsForIndex(?Model $attribute = null): Collection
    {
        return $this->getAdminFields($attribute)
            ->filter(fn($field) => !in_array($field[1], ['password', 'remember_token']));
    }

    public function getCrudIndex()
    {
        return route('adminify.crud.index', ['model' => $this->getTable()]);
    }
}
