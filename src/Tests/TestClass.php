<?php

namespace Sim\Event\Tests;

use Sim\Event\Event;
use Sim\Event\Interfaces\IEmitter;

class TestClass
{
    /**
     * @var IEmitter $emitter
     */
    protected $emitter;

    public function __construct(IEmitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function boot()
    {
        echo 'I am booting' . PHP_EOL;
        $boot_evt = $this->emitter->dispatch(new Event('boot'));
        $returnVal = is_null($boot_evt->getReturnValue()) ? 'null' : (false === $boot_evt->getReturnValue() ? 'false' : $boot_evt->getReturnValue());
        echo 'Last returned value before stop propagation is: ' . $returnVal . PHP_EOL;
        echo '----------' . PHP_EOL;
    }

    public function close()
    {
        echo 'I am closing...' . PHP_EOL;
        $this->emitter->dispatch(new Event('close'));
    }
}
