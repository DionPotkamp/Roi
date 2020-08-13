<?php

namespace Roi\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

/**
 * Class ResponseListener
 * @package Roi\Events
 *
 * This Response listener is called on every request.
 * If the controller result is a string convert it to a Response.
 * A rendered twig template is also a string.
 *
 */

class ResponseListener implements EventSubscriberInterface
{

    public function onView(ViewEvent $event)
    {
        $response = $event->getControllerResult();

        if (is_string($response)) {
            $event->setResponse(new Response($response));
        }
    }

    public static function getSubscribedEvents()
    {
        return ['kernel.view' => 'onView'];
    }
}