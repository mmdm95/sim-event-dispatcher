<?php

namespace Sim\Event\Interfaces;


interface IEvent extends StoppableEventInterface
{
    /**
     * @return IEvent
     */
    public function stopPropagation(): IEvent;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $value
     * @return IEvent
     */
    public function setReturnValue($value): IEvent;

    /**
     * @return mixed
     */
    public function getReturnValue();
}