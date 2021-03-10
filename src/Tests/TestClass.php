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

        echo "<pre>";
        echo 'I am from construct' . '<br>';
//         remove first event!
        $this->emitter->removeAllListeners('boot:?.*');
        echo '** All events with boot prefix got removed.' . '<br>';
        echo "</pre>";

        // boot inside constructor method
        $this->emitter->dispatch('boot:construct');
    }

    public function boot()
    {
        echo "<pre>";
        echo 'I am booting' . '<br>';
//         remove first event!
//        $this->emitter->removeListener('boot', 'boot_first_evt');
//        echo '** First event of boot got removed.' . '<br>';
        echo "</pre>";
        // remove all boot events!
//        $this->emitter->removeAllListeners('boot');
        // now dispatch al boot closures
        $boot_evt = $this->emitter->dispatch('boot');
        // last return value
        $returnVal = is_null($boot_evt->getReturnValue()) ? 'null' : (false === $boot_evt->getReturnValue() ? 'false' : $boot_evt->getReturnValue());
        echo "<pre>";
        echo 'Last returned value before stop propagation is: ' . $returnVal . PHP_EOL;
        echo '----------' . '<br>';
        echo "</pre>";
    }

    public function close()
    {
        echo "<pre>";
        echo 'I am closing...' . '<br>';
        echo "</pre>";
        $this->emitter->dispatch('close');
    }
}
