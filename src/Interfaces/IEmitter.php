<?php

namespace Sim\Event\Interfaces;


use Closure;

interface IEmitter extends EventDispatcherInterface
{
    /**
     * @param IEvent $event
     * @param Closure $listener
     * @param int $priority
     * @return IEmitter
     */
    public function addListener(IEvent $event, Closure $listener, int $priority = 0): IEmitter;

    /**
     * @param IEvent $event
     * @param Closure $listener
     * @return IEmitter
     */
    public function removeListener(IEvent $event, Closure $listener): IEmitter;

    /**
     * @param IEvent $event
     * @return array
     */
    public function getListener(IEvent $event): array;

    /**
     * @return array
     */
    public function getAllListener(): array;
}