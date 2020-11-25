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
     * @param string $event_name
     * @return IEvent|null
     *   The Event that was passed, now modified by listeners.
     */
    public function dispatch(string $event_name): ?IEvent;
}