<?php

use Sim\Event\Tests\TestClass;

include_once 'manager.php';

$emitterTester = new TestClass($emitter, $closure_provider);
$emitterTester->boot();
$emitterTester->close();
