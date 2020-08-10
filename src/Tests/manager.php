<?php

use Sim\Event\ClosureProvider;
use Sim\Event\Emitter;
use Sim\Event\Event;

include_once '../../vendor/autoload.php';

$boot_evt = new Event('boot');
// closure provider to store all closures
$closure_provider = new ClosureProvider();
$closure_provider->addClosure('boot_last_evt', function (Event $event) {
    echo $event->getName() . ': This event goes later' . PHP_EOL;
    echo '----------' . PHP_EOL;
    return false;
})->addClosure('close_evt', function (Event $event) {
    echo $event->getName() . ': Event emitted' . PHP_EOL;
    echo '----------' . PHP_EOL;
})->addClosure('boot_first_evt', function (Event $event) {
    echo $event->getName() . ': This event goes first' . PHP_EOL;
    echo '----------' . PHP_EOL;
    return 'hi';
})->addClosure('boot_not_showed_evt', function (Event $event) {
    echo $event->getName() . ': This event never displayed!' . PHP_EOL;
    echo '----------' . PHP_EOL;
});
// instantiate emitter
$emitter = new Emitter($closure_provider);
// define events' callback
$emitter->addListener($boot_evt, $closure_provider->getClosure('boot_last_evt'), 2)
    ->addListener(new Event('close'), $closure_provider->getClosure('close_evt'), 3)
    ->addListener($boot_evt, $closure_provider->getClosure('boot_first_evt'), 3)
    ->addListener($boot_evt, $closure_provider->getClosure('boot_not_showed_evt'), 1);
