<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IClosureProvider;
use Sim\Event\Interfaces\IEmitter;
use Sim\Event\Interfaces\IEvent;

class Emitter implements IEmitter
{
    /**
     * @var ListenerProvider $listenerProvider
     */
    protected $listenerProvider;

    protected $closer_provider;

    /**
     * Emitter constructor.
     * @param IClosureProvider $closure_provider
     */
    public function __construct(IClosureProvider $closure_provider)
    {
        $this->listenerProvider = new ListenerProvider();
        $this->closer_provider = $closure_provider;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener(IEvent $event, Closure $listener, int $priority = 0): IEmitter
    {
        $this->listenerProvider->addListener($event, $listener, $priority);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener(IEvent $event, string $closure_name): IEmitter
    {
        $listener = $this->closer_provider->getClosure($closure_name);
        $this->listenerProvider->removeListener($event, $listener);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllListener(IEvent $event): IEmitter
    {
        $this->listenerProvider->removeListener($event, null);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getListener(IEvent $event): array
    {
        return $this->listenerProvider->getListenersForEvent($event);
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