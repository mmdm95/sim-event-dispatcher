<?php

namespace Sim\Event;

use Sim\Event\Interfaces\IEvent;
use Sim\Event\Interfaces\IEventProvider;

class EventProvider implements IEventProvider
{
    /**
     * @var array $events
     */
    protected $events = [];

    /**
     * {@inheritdoc}
     */
    public function addEvent(IEvent $event): IEventProvider
    {
        $this->events[$event->getName()] = $event;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEvent(string $event_name): IEventProvider
    {
        unset($this->events[$event_name]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(string $event_name): IEvent
    {
        return $this->events[$event_name] ?? null;
    }

    /**
     * @param string $event_name
     * @return bool
     */
    public function hasEvent(string $event_name): bool
    {
        return isset($this->events[$event_name]);
    }
}
