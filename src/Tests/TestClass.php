<?php

namespace Sim\Event\Tests;

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
//         remove first event!
        $this->emitter->removeListener('boot', 'boot_first_evt');
        echo '** First event of boot got removed.' . PHP_EOL;
        // remove all boot events!
//        $this->emitter->removeAllListeners('boot');
        // now dispatch al boot closures
        $boot_evt = $this->emitter->dispatch('boot');
        // last return value
        $returnVal = is_null($boot_evt->getReturnValue()) ? 'null' : (false === $boot_evt->getReturnValue() ? 'false' : $boot_evt->getReturnValue());
        echo 'Last returned value before stop propagation is: ' . $returnVal . PHP_EOL;
        echo '----------' . PHP_EOL;
    }

    public function close()
    {
        echo 'I am closing...' . PHP_EOL;
        $this->emitter->dispatch('close');
    }
}
