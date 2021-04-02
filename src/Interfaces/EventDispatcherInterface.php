<?php

namespace Sim\Event\Interfaces;

use Sim\Event\Event;

/**
 * Defines a dispatcher for events.
 */
interface EventDispatcherInterface
{
    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param string|Event $event
     * @return array|IEvent|null
     *   The Event that was passed, now modified by listeners.
     */
    public function dispatch($event);
}