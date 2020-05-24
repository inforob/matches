<?php

namespace App\EventSubscriber;

use App\Events\SneakEvent;
use App\Services\GoalSMSService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class SneakSubscriber implements EventSubscriberInterface
{

    private $smsService;

    public function __construct(GoalSMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    public static function getSubscribedEvents()
    {
        return [
            'sneak.event'       => 'onSneakEvent'
        ];
    }

    /**
     * @param GoalSMSService $goalservice
     * @param $event
     */
    public function onSneakEvent($event)
    {
        /** @var SneakEvent $event */
        $goals = $event->getGoals();
        foreach ($goals as $goal) {
            $this->smsService->sendSMS($goal);
        }

    }
}
