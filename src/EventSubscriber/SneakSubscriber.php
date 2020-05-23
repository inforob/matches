<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class SneakSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            'sneak.event' => 'onSampleEvent',
            'kernel.controller' => 'onKernelController',
        ];
    }

    public function onSampleEvent($event)
    {
        // ...
        touch(__DIR__.'/test.sample.file1');
    }
}
