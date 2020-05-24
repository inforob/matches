<?php
namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class SneakEvent extends Event
{
    const NAME = 'sneak.event';

    protected $goals;

    public function __construct(array $goals)
    {
        $this->goals = $goals;
    }

    public function getGoals()
    {
        return $this->goals;
    }
}