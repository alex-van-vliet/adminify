<?php


namespace AlexVanVliet\Adminify\Http\Controllers;


class IndexController extends Controller
{
    public function __invoke()
    {
        $this->authorize('adminify.admin.index');

        return view('adminify::index');
    }
}
