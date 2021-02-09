<?php


namespace AlexVanVliet\Adminify\Http\Controllers;


class IndexController extends Controller
{
    public function __invoke()
    {
        return view('adminify::index');
    }
}
