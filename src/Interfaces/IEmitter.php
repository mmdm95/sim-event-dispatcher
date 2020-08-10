<?php

namespace Sim\Event\Interfaces;


use Closure;

interface IEmitter extends EventDispatcherInterface
{
    /**
     * @param IEvent $event
     * @param string $closure_name
     * @param int $priority
     * @return IEmitter
     */
    public function addListener(IEvent $event, string $closure_name, int $priority = 0): IEmitter;

    /**
     * @param IEvent $event
     * @param string $closure_name
     * @return IEmitter
     */
    public function removeListener(IEvent $event, string $closure_name): IEmitter;

    /**
     * @param IEvent $event
     * @return IEmitter
     */
    public function removeAllListener(IEvent $event): IEmitter;

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