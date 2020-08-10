<?php

namespace Sim\Event;

use Sim\Event\Interfaces\IEvent;

class Event implements IEvent
{
    /**
     * @var bool $stopped
     */
    protected $stopped = false;

    /**
     * @var string|null $name
     */
    protected $name = null;

    /**
     * @var mixed|null $value
     */
    protected $value = null;

    /**
     * Event constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = (string)$name;
    }

    /**
     * Is propagation stopped?
     *
     * This will typically only be used by the Dispatcher to determine if the
     * previous listener halted propagation.
     *
     * @return bool
     *   True if the Event is complete and no further listeners should be called.
     *   False to continue calling listeners.
     */
    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }

    /**
     * @return IEvent
     */
    public function stopPropagation(): IEvent
    {
        $this->stopped = true;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $value
     * @return IEvent
     */
    public function setReturnValue($value): IEvent
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnValue()
    {
        return $this->value;
    }
}