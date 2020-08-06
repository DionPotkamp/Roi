<?php

namespace Roi\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ResponseListener implements EventSubscriberInterface
{

    public function onView(ViewEvent $event)
    {
        $response = $event->getControllerResult();

        // This can be just a string but also a rendered twig template
        if (is_string($response)) {
            $event->setResponse(new Response($response));
        }
    }

    public static function getSubscribedEvents()
    {
        return ['kernel.view' => 'onView'];
    }
}