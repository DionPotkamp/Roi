<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Roi\Route;

// Create the request
$request = Request::createFromGlobals();
$requestStack = new RequestStack();

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

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));
$dispatcher->addSubscriber(new HttpKernel\EventListener\ErrorListener('Roi\ErrorHandler::exception'));
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));
$dispatcher->addSubscriber(new Roi\Events\StringResponseListener());

// Initialize new Roi Framework and get the response
$framework = new Roi\Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
$response = $framework->handle($request);

// Send the response(content) of the request back to the user
$response->send();
