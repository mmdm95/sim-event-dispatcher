<?php

namespace Sim\Event;

use Closure;
use ReflectionFunction;
use Sim\Event\Interfaces\IEvent;
use SplFileObject;

class Listener
{
    /**
     * @var \Closure|null $callable
     */
    protected $callable = null;

    /**
     * @var string|null $hashed
     */
    protected $hashed = null;

    /**
     * Listener constructor.
     * @param \Closure $callable
     */
    public function __construct(\Closure $callable)
    {
        $this->callable = $callable;
        try {
            $this->hashCallable($callable);
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * @return \Closure|null
     */
    public function getClosure()
    {
        return $this->callable;
    }

    /**
     * @param array $parameters
     * @return Closure
     */
    public function call(array $parameters = [])
    {
        $callable = $this->callable;
        return function (IEvent &$event) use ($callable, $parameters) {
            $res = $callable($event, ...$parameters);
            if (false === $res) {
                $event->stopPropagation();
            } else {
                $event->setReturnValue($res);
            }
        };
    }

    /**
     * @return string|null
     */
    public function getHashed()
    {
        return $this->hashed;
    }

    /**
     * Hash the closure
     *
     * @see https://stackoverflow.com/questions/13983714/serialize-or-hash-a-closure-in-php
     * @param Closure $closure
     * @throws \ReflectionException
     */
    protected function hashCallable(Closure $closure)
    {
        $ref = new ReflectionFunction($closure);
        $file = new SplFileObject($ref->getFileName());
        $file->seek($ref->getStartLine() - 1);
        $content = '';
        while ($file->key() < $ref->getEndLine()) {
            $content .= $file->current();
            $file->next();
        }
        $this->hashed = md5(json_encode(array(
            $content,
            $ref->getStaticVariables()
        )));
    }
}