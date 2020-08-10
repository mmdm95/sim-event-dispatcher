<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IEvent;

class Listener
{
    /**
     * @var callable|null $callable
     */
    protected $callable = null;

    /**
     * Listener constructor.
     * @param Closure $callable
     */
    public function __construct(Closure $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param array $parameters
     * @return Closure
     */
    public function call(array $parameters = [])
    {
        $callable = $this->callable;
        return function (IEvent &$event) use ($callable, $parameters) {
            $res = $callable($event, ...$parameters);
            if (false === $res) {
                $event->stopPropagation();
            } else {
                $event->setReturnValue($res);
            }
        };
    }
}