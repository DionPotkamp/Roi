<?php
namespace Roi;

use Symfony\Component\Routing;

class Route
{
    private $routes;
    private $namespace;

    public function __construct()
    {
        $this->routes = new Routing\RouteCollection();
        $this->namespace = env('controllers.namespace');
    }

    /**
     * @param \Symfony\Component\Routing\string|string $name of the route
     * @param string $uri of the route
     * @param string|array $controller the route is bind to
     * @param array $defaults If a parameter is missing in the url, use the value assigned in this array
     */
    public function add($name, $uri, $controller, $defaults = array()) {
        $defaults['_controller'] = $this->namespace.$controller;
        $this->routes->add($name, new Routing\Route($uri, $defaults));
    }

    /**
     * @return Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}