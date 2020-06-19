<?php


namespace Simplex;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentLengthListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event)
    {
        if (!$event->getResponse()->headers->has('Content-Length')
            && $event->getResponse()->headers->has('Transfer-Encoding')
        ) {
            $event->getResponse()->headers->set('Content-Length', strlen($event->getResponse()->getContent()));
        }
    }

    public static function getSubscribedEvents()
    {
        return ['response' => ['onResponse', -255]];
    }
}