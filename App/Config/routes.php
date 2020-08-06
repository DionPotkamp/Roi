<?php

$route->add('home', '/', 'HomeController::index');

$route->add('twig', '/twig', 'HomeController::twig');

$route->add('hello', '/hello/{name}', 'HomeController::hello', [
    // Set default value
    'name' => 'Roi'
]);

$route->add('leap_year', '/is_leap_year/{year}', 'Calendar\\LeapYearController::index', [
    'year' => date('Y')
]);
