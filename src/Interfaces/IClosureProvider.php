<?php

namespace Sim\Event\Interfaces;

use Closure;

interface IClosureProvider
{
    /**
     * This method add a closure to provider
     *
     * Note:
     *  If any closure with $key exists, it'll be replaced
     *
     * @param string $key
     * @param $closure
     * @return IClosureProvider
     */
    public function addClosure(string $key, Closure $closure): IClosureProvider;

    /**
     * @param string $key
     * @return IClosureProvider
     */
    public function removeClosure(string $key): IClosureProvider;

    /**
     * @param string $key
     * @return Closure
     */
    public function getClosure(string $key): Closure;

    /**
     * @param string $key
     * @return bool
     */
    public function hasClosure(string $key): bool;
}