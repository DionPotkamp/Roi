<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(Request $request)
    {
        return new Response("Home");
    }

    public function hello(Request $request, $name)
    {
        return new Response('Hello '.$name);
    }
}