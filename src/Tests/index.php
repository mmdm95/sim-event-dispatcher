<?php

use Sim\Event\Tests\TestClass;

include_once 'manager.php';

$emitterTester = new TestClass($emitter);
$emitterTester->boot();
$emitterTester->close();
