<?php


namespace AlexVanVliet\Adminify\Tests\Feature\Crud;


use AlexVanVliet\Adminify\Tests\PageTest;
use AlexVanVliet\Adminify\Tests\User;

class CreatePageTest extends PageTest
{
    protected function route()
    {
        return route('adminify.crud.create', ['model' => (new User())->getTable()]);
    }

    protected function request()
    {
        return $this->get($this->route());
    }
}
