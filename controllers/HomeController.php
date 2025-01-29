<?php

namespace App\Controllers;


use App\Providers\View;

class HomeController
{
    public function index()
    {
        return View::render('home', ['title' => 'Index']);
    }
}
