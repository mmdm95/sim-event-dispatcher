<?php

namespace Sim\Event\Interfaces;

/**
 * Defines a dispatcher for events.
 */
interface EventDispatcherInterface
{
    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param IEvent $event
     *   The object to process.
     *
     * @return IEvent
     *   The Event that was passed, now modified by listeners.
     */
    public function dispatch(IEvent $event): IEvent;
}