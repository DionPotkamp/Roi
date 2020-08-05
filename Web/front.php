<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use Roi\Route;

// Create the request
$request = Request::createFromGlobals();

// Define the routes
$route = new Route();
include __DIR__ . '/../App/Config/routes.php';
$routes = $route->getRoutes();

// Create context from request (url, path, host ec.)
$context = new Routing\RequestContext();
// Create a route context matcher
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

// Initialize new Roi Framework and get the response
$framework = new Roi\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

// Send the answer/response(content) of the request
$response->send();
