<?php

namespace Sim\Event\Interfaces;

use Closure;
use Sim\Event\Event;

interface IEmitter extends EventDispatcherInterface
{
    /**
     * @param string|Event $event
     * @param string|Closure $closure
     * @param int $priority
     * @return IEmitter
     */
    public function addListener($event, $closure, int $priority = 0): IEmitter;

    /**
     * @param string|Event $event
     * @param string|Closure $closure
     * @return IEmitter
     */
    public function removeListener($event, $closure): IEmitter;

    /**
     * @param string|Event $event
     * @return IEmitter
     */
    public function removeAllListeners($event): IEmitter;

    /**
     * @param string|Event $event
     * @return array
     */
    public function getListener($event): array;

    /**
     * @return array
     */
    public function getAllListeners(): array;
}