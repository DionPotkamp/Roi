<?php

$route->add('home', '/', 'HomeController::index');

$route->add('hello', '/hello/{name}', 'HomeController::hello', [
    'name' => 'world'
]);

$route->add('leap_year', '/is_leap_year/{year}', 'Calendar\\LeapYearController::index', [
    'year' => null
]);
