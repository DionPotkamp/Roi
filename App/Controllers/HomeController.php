<?php

namespace App\Controllers;

use Roi\BaseController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        return $this->render("Home");
    }

    public function hello(Request $request, $name)
    {
        return $this->render('hello', compact('name'));
    }
}