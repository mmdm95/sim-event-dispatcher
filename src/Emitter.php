<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IClosureProvider;
use Sim\Event\Interfaces\IEmitter;
use Sim\Event\Interfaces\IEvent;
use Sim\Event\Interfaces\IEventProvider;

class Emitter implements IEmitter
{
    /**
     * @var ListenerProvider $listener_provider
     */
    protected $listener_provider;

    /**
     * @var IEventProvider|null $event_provider
     */
    protected $event_provider;

    /**
     * @var IClosureProvider|null $closure_provider
     */
    protected $closure_provider;

    /**
     * Emitter constructor.
     * @param IEventProvider|null $event_provider
     * @param IClosureProvider|null $closure_provider
     */
    public function __construct(?IEventProvider &$event_provider = null, ?IClosureProvider &$closure_provider = null)
    {
        $this->listener_provider = new ListenerProvider();
        $this->closure_provider = $closure_provider;
        $this->event_provider = $event_provider;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($event, $closure, int $priority = 0): IEmitter
    {
        $evt = $this->getEvent($event);
        $listener = $this->getClosure($closure);
        if (null !== $evt && null !== $listener) {
            $this->listener_provider->addListener($evt, $listener, $priority);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($event, $closure): IEmitter
    {
        $evt = $this->getEvent($event);
        $listener = $this->getClosure($closure);
        if (null !== $evt && null !== $listener) {
            $this->listener_provider->removeListener($evt, $listener);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllListeners($event): IEmitter
    {
        $evt = $this->getEvent($event);
        if (null !== $evt) {
            $this->listener_provider->removeListener($evt, null);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getListener($event): array
    {
        $evt = $this->getEvent($event);
        if (null !== $evt) {
            return $this->listener_provider->getListenersForEvent($evt);
        }
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllListeners(): array
    {
        return $this->listener_provider->getListeners();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($event, $arguments = []): ?IEvent
    {
        $evt = $this->getEvent($event);
        if (null !== $evt) {
            $listeners = $this->getListener($event);
            foreach ($listeners as $priority => $callable) {
                if ($evt->isPropagationStopped()) break;
                $callable->call($arguments)($evt);
            }
        }
        return $evt;
    }

    /**
     * @param string|Event $event
     * @return IEvent|null
     */
    protected function getEvent($event): ?IEvent
    {
        $evt = null;
        if ($event instanceof IEvent) {
            $evt = $event;
        } elseif (is_string($event) && null !== $this->event_provider) {
            if ($this->event_provider->hasEvent($event)) {
                $evt = $this->event_provider->getEvent($event);
            }
        }
        return $evt;
    }

    /**
     * @param string|Closure $closure
     * @return Closure|null
     */
    protected function getClosure($closure): ?Closure
    {
        $cl = null;
        if ($closure instanceof Closure) {
            $cl = $closure;
        } elseif (is_string($closure) && null !== $this->closure_provider) {
            if ($this->closure_provider->hasClosure($closure)) {
                $cl = $this->closure_provider->getClosure($closure);
            }
        }
        return $cl;
    }
}