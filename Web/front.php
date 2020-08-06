<?php
require_once __DIR__.'/../vendor/autoload.php';

use Roi\Route;
use Symfony\Component\HttpFoundation\Request;

// Define the routes
$route = new Route();
include __DIR__ . '/../App/Config/routes.php';
$routes = $route->getRoutes();

// Create the request
$request = Request::createFromGlobals();

// Create the container and register all the classes
$container = include __DIR__.'/../Src/Roi/container.php';
// Set some important required parameters for the container
$container->setParameter('debug', true);
$container->setParameter('routes', $routes);
$container->setParameter('charset', 'UTF-8');

// Get the dependency injected framework and handle the request
$response = $container->get('framework')->handle($request);

// Send the response(content) of the request back to the user
$response->send();
