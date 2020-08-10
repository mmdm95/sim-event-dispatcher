<?php

namespace Sim\Event\Interfaces;


interface IClosureProvider
{
    /**
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
     * @return \Closure
     */
    public function getClosure($key): \Closure;
}