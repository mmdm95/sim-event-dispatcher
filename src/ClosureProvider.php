<?php

namespace Sim\Event;

use Sim\Event\Interfaces\IClosureProvider;

class ClosureProvider implements IClosureProvider
{
    /**
     * @var array $closures
     */
    protected $closures = [];

    /**
     * @var \Closure
     */
    protected $noop;

    /**
     * ClosureProvider constructor.
     */
    public function __construct()
    {
        $this->noop = function () {
        };
    }

    /**
     * {@inheritdoc}
     */
    public function addClosure($key, $closure): IClosureProvider
    {
        $this->closures[$key] = $closure;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeClosure($key): IClosureProvider
    {
        unset($this->closures[$key]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClosure($key): \Closure
    {
        return $this->closures[$key] ?? $this->noop;
    }

    /**
     * {@inheritdoc}
     */
    public function hasClosure($key): bool
    {
        return isset($this->closures[$key]);
    }
}