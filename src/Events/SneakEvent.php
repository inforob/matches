<?php
namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class SneakEvent extends Event
{
    const NAME = 'sneak.event';

    protected $foo;

    public function __construct()
    {
        $this->foo = 'bar';
    }

    public function getFoo()
    {
        return $this->foo;
    }
}