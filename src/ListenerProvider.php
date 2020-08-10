<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IEvent;
use Sim\Event\Interfaces\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    protected $listeners = [];

    /**
     * @param IEvent $event
     *   An event for which to return the relevant listeners.
     * @return array<callable>
     *   An iterable (array, iterator, or generator) of callables.  Each
     *   callable MUST be type-compatible with $event.
     */
    public function getListenersForEvent(IEvent $event): array
    {
        $listener = [];
        if (isset($this->listeners[$event->getName()])) {
            $listener = $this->_sortListeners($this->listeners[$event->getName()]);
        }
        return $listener;
    }

    /**
     * @return array
     */
    public function getListeners(): array
    {
        $listeners = [];
        foreach ($this->listeners as $event => $priority) {
            $listeners[$event] = $this->_sortListeners($priority);
        }
        return $listeners;
    }

    /**
     * Structure of storage:
     *   $listeners[$eventName][$priority][$closure]
     *   $listeners['user:delete'][10][Closure1]
     *   $listeners['user:delete'][12][Closure2]
     *   $listeners['user:delete'][8][Closure3]
     *   etc.
     *
     * Higher priority will execute first
     * Equal priority will execute in add order
     *
     * @param IEvent $event
     * @param Closure $listener
     * @param int $priority
     * @return ListenerProvider
     */
    public function addListener(IEvent $event, Closure $listener, int $priority = 0): ListenerProvider
    {
        if (!isset($this->listeners[$event->getName()][$priority])) {
            $this->listeners[$event->getName()][$priority] = [];
        }
        $this->listeners[$event->getName()][$priority][] = new Listener($listener);
        return $this;
    }

    /**
     * @param IEvent $event
     * @param Closure $listener
     * @return ListenerProvider
     */
    public function removeListener(IEvent $event, Closure $listener): ListenerProvider
    {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->listeners[$event->getName()] as $priority => $listeners) {
                foreach ($this->listeners[$event->getName()][$priority] as $key => $callable) {
                    if ($callable === $listener) {
                        // remove callable from all event in specific priority
                        unset($this->listeners[$event->getName()][$priority][$key]);

                        // if event in specific priority is empty, remove it
                        if (empty($this->listeners[$event->getName()][$priority])) {
                            unset($this->listeners[$event->getName()][$priority]);

                            // if event is empty, remove it too
                            if (empty($this->listeners[$event->getName()])) {
                                unset($this->listeners[$event->getName()]);
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }

    /**
     * This function is for sorting listeners in priority order
     *
     * @param array $listeners
     * @return array
     */
    protected function _sortListeners(array $listeners): array
    {
        krsort($listeners);
        return array_merge(...$listeners);
    }
}