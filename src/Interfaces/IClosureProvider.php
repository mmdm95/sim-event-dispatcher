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
     * @param $key
     * @param $closure
     * @return IClosureProvider
     */
    public function addClosure($key, $closure): IClosureProvider;

    /**
     * @param $key
     * @return IClosureProvider
     */
    public function removeClosure($key): IClosureProvider;

    /**
     * @param $key
     * @return Closure
     */
    public function getClosure($key): Closure;

    /**
     * @param $key
     * @return bool
     */
    public function hasClosure($key): bool;
}