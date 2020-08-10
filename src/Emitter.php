<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IEmitter;
use Sim\Event\Interfaces\IEvent;

class Emitter implements IEmitter
{
    protected $listenerProvider;

    public function __construct()
    {
        $this->listenerProvider = new ListenerProvider();
    }

    /**
     * @param IEvent $event
     * @param Closure $listener
     * @param int $priority
     * @return IEmitter
     */
    public function addListener(IEvent $event, Closure $listener, int $priority = 0): IEmitter
    {
        $this->listenerProvider->addListener($event, $listener, $priority);
        return $this;
    }

    /**
     * @param IEvent $event
     * @param Closure $listener
     * @return IEmitter
     */
    public function removeListener(IEvent $event, Closure $listener): IEmitter
    {
        $this->listenerProvider->removeListener($event, $listener);
        return $this;
    }

    /**
     * @param IEvent $event
     * @return array
     */
    public function getListener(IEvent $event): array
    {
        return $this->listenerProvider->getListenersForEvent($event);
    }

    /**
     * @return array
     */
    public function getAllListener(): array
    {
        return $this->listenerProvider->getListeners();
    }

    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param IEvent $event
     *   The object to process.
     *
     * @param array $arguments
     * @return IEvent
     *   The Event that was passed, now modified by listeners.
     */
    public function dispatch(IEvent $event, $arguments = []): IEvent
    {
        $listeners = $this->getListener($event);
        foreach ($listeners as $priority => $callable) {
            if ($event->isPropagationStopped()) break;
            $callable->call($arguments)($event);
        }
        return $event;
    }
}