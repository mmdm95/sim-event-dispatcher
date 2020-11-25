<?php

namespace Sim\Event;

use Sim\Event\Interfaces\IClosureProvider;
use Sim\Event\Interfaces\IEmitter;
use Sim\Event\Interfaces\IEvent;
use Sim\Event\Interfaces\IEventProvider;

class Emitter implements IEmitter
{
    /**
     * @var ListenerProvider $listenerProvider
     */
    protected $listenerProvider;

    /**
     * @var IEventProvider $event_provider
     */
    protected $event_provider;

    /**
     * @var IClosureProvider $closure_provider
     */
    protected $closure_provider;

    /**
     * Emitter constructor.
     * @param IEventProvider $event_provider
     * @param IClosureProvider $closure_provider
     */
    public function __construct(IEventProvider &$event_provider, IClosureProvider &$closure_provider)
    {
        $this->listenerProvider = new ListenerProvider();
        $this->closure_provider = $closure_provider;
        $this->event_provider = $event_provider;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener(string $event_name, string $closure_name, int $priority = 0): IEmitter
    {
        if ($this->event_provider->hasEvent($event_name)) {
            $event = $this->event_provider->getEvent($event_name);
            $listener = $this->closure_provider->getClosure($closure_name);
            $this->listenerProvider->addListener($event, $listener, $priority);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener(string $event_name, string $closure_name): IEmitter
    {
        if ($this->event_provider->hasEvent($event_name)) {
            $event = $this->event_provider->getEvent($event_name);
            $listener = $this->closure_provider->getClosure($closure_name);
            $this->listenerProvider->removeListener($event, $listener);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllListener(string $event_name): IEmitter
    {
        if ($this->event_provider->hasEvent($event_name)) {
            $event = $this->event_provider->getEvent($event_name);
            $this->listenerProvider->removeListener($event, null);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getListener(string $event_name): array
    {
        if ($this->event_provider->hasEvent($event_name)) {
            $event = $this->event_provider->getEvent($event_name);
            return $this->listenerProvider->getListenersForEvent($event);
        }
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllListener(): array
    {
        return $this->listenerProvider->getListeners();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(string $event_name, $arguments = []): ?IEvent
    {
        $event = null;
        if ($this->event_provider->hasEvent($event_name)) {
            $event = $this->event_provider->getEvent($event_name);
            $listeners = $this->getListener($event_name);
            foreach ($listeners as $priority => $callable) {
                if ($event->isPropagationStopped()) break;
                $callable->call($arguments)($event);
            }
        }
        return $event;
    }
}