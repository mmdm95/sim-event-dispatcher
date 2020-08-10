<?php

use Sim\Event\ClosureProvider;
use Sim\Event\Emitter;
use Sim\Event\Event;
use Sim\Event\EventProvider;

include_once '../../vendor/autoload.php';

// event provider to store all events
$event_provider = new EventProvider();
$event_provider->addEvent(new Event('boot'))
    ->addEvent(new Event('close'));
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
$emitter = new Emitter($event_provider, $closure_provider);
// define events' callback
$emitter->addListener('boot', 'boot_last_evt', 2)
    ->addListener('close', 'close_evt', 3)
    ->addListener('boot', 'boot_first_evt', 3)
    ->addListener('boot', 'boot_not_showed_evt', 1);
