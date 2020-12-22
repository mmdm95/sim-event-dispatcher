<?php

namespace Sim\Event;

use Closure;
use Sim\Event\Interfaces\IClosureProvider;

class ClosureProvider implements IClosureProvider
{
    /**
     * @var array $closures
     */
    protected $closures = [];

    /**
     * @var Closure
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
    public function addClosure(string $key, Closure $closure): IClosureProvider
    {
        $this->closures[$key] = $closure;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeClosure(string $key): IClosureProvider
    {
        unset($this->closures[$key]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClosure(string $key): Closure
    {
        return $this->closures[$key] ?? $this->noop;
    }

    /**
     * {@inheritdoc}
     */
    public function hasClosure(string $key): bool
    {
        return isset($this->closures[$key]);
    }
}