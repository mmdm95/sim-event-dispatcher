<?php

namespace Sim\Event\Interfaces;

interface IEventProvider
{
    /**
     * @param IEvent $event
     * @return IEventProvider
     */
    public function addEvent(IEvent $event): IEventProvider;

    /**
     * @param string $event_name
     * @return IEventProvider
     */
    public function removeEvent(string $event_name): IEventProvider;

    /**
     * @param string $event_name
     * @return IEvent|null
     */
    public function getEvent(string $event_name): IEvent;

    /**
     * @param string $event_name
     * @return bool
     */
    public function hasEvent(string $event_name): bool;
}