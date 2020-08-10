<?php

namespace Sim\Event\Interfaces;


use Closure;

interface IEmitter extends EventDispatcherInterface
{
    /**
     * @param string $event_name
     * @param string $closure_name
     * @param int $priority
     * @return IEmitter
     */
    public function addListener(string $event_name, string $closure_name, int $priority = 0): IEmitter;

    /**
     * @param string $event_name
     * @param string $closure_name
     * @return IEmitter
     */
    public function removeListener(string $event_name, string $closure_name): IEmitter;

    /**
     * @param string $event_name
     * @return IEmitter
     */
    public function removeAllListener(string $event_name): IEmitter;

    /**
     * @param string $event_name
     * @return array
     */
    public function getListener(string $event_name): array;

    /**
     * @return array
     */
    public function getAllListener(): array;
}