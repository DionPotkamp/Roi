<?php


namespace Roi;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            // Searches through the defined routes with the given path/url
            // Returns the parameters from the route and adds it to the request
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            // Get the controller and the arguments from the request
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            // Call the controller and pass it the arguments
            return call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $exception) {
            // Throw custom not found error
            return new Response('Not Found', 404);
        } catch (\Exception $exception) {
            // Throw custom server error error
            return new Response('An error occurred<br><pre>'.$exception, 500);
        }
    }

}