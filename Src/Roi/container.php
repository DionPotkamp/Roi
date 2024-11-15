<?php

use Roi\Events\ResponseListener;
use Roi\Framework;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

// Create a new dependency injection object
$containerBuilder = new DependencyInjection\ContainerBuilder();

// Register all the classes to be able to inject them
$containerBuilder->register('context', Routing\RequestContext::class);

//$containerBuilder
//    ->register('twig.filesystemLoader', 'Twig\Loader\FilesystemLoader')//::class)
//    ->setArguments([
//        env('templates.dir')
//    ]);
//
//$containerBuilder
//    ->register('twig.environment', 'Twig\Environment')//::class)
//    ->setArguments([
//        new Reference('twig.filesystemLoader'),
//        [
//            'cache' => env('templates.cache'), // Cache directory
//            'debug' => env('app.debug')
//        ]
//    ]);
//
//$containerBuilder
//    ->register('roi.basecontroller', 'Roi\BaseController')//::class)
//    ->setArguments([
//        new Reference('twig.environment')
//    ]);

$containerBuilder
    ->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments([
        '%routes%',
        new Reference('context')
    ]);

$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);

$containerBuilder->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);

$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$containerBuilder
    ->register('listener.router', HttpKernel\EventListener\RouterListener::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference('request_stack')
    ]);

$containerBuilder
    ->register('listener.charset_response', HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(['%charset%']);

$containerBuilder
    ->register('listener.exception', HttpKernel\EventListener\ErrorListener::class)
    ->setArguments(['Roi\ErrorHandler::exception']);

$containerBuilder->register('listener.response', ResponseListener::class);


// Register dispatcher(events) and subscribe the earlier registered listeners
$containerBuilder
    ->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.charset_response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')]);

$containerBuilder
    ->register('framework', Framework::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ]);

return $containerBuilder;

// Return a object with all the registered container definitions
// Each definition has a ID with the class and their dependencies attached:

//ContainerBuilder {
//    -definitions: array:11 [
//        ...
//        "framework" => Symfony\Component\DependencyInjection\Definition {
//             -class: "Roi\Framework"
//             #arguments: array:4 [
//                  0 => Symfony\Component\DependencyInjection\Reference {
//                      -id: "dispatcher"
//                      -invalidBehavior: 1
//                  }
//                  1 => Symfony\Component\DependencyInjection\Reference {}
//                  2 => Symfony\Component\DependencyInjection\Reference {}
//                  3 => Symfony\Component\DependencyInjection\Reference {}
//              ]
//          }
//     ]
//}
