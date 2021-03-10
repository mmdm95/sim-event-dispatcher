<?php

use Sim\Event\ClosureProvider;
use Sim\Event\Emitter;
use Sim\Event\Event;
use Sim\Event\EventProvider;

include_once '../../vendor/autoload.php';
//include_once '../../autoloader.php';

// event provider to store all events
$event_provider = new EventProvider();
$event_provider
    ->addEvent(new Event('boot'))
    ->addEvent(new Event('boot:construct'))
    ->addEvent(new Event('close'));
// closure provider to store all closures
$closure_provider = new ClosureProvider();
$closure_provider->addClosure('boot_last_evt', function (Event $event) {
    echo "<pre>";
    echo $event->getName() . ': This event goes later' . '<br>';
    echo '----------' . '<br>';
    echo "</pre>";
    return false;
})->addClosure('close_evt', function (Event $event) {
    echo "<pre>";
    echo $event->getName() . ': Event emitted' . '<br>';
    echo '----------' . '<br>';
    echo "</pre>";
})->addClosure('boot_first_evt', function (Event $event) {
    echo "<pre>";
    echo $event->getName() . ': This event goes first' . '<br>';
    echo '----------' . '<br>';
    echo "</pre>";
    return 'hi';
})->addClosure('boot_not_showed_evt', function (Event $event) {
    echo "<pre>";
    echo $event->getName() . ': This event never displayed!' . '<br>';
    echo '----------' . '<br>';
    echo "</pre>";
});
// instantiate emitter
$emitter = new Emitter($event_provider, $closure_provider);
// define events' callback
$emitter->addListener('boot', 'boot_last_evt', 2)
    ->addListener('close', 'close_evt', 3)
    ->addListener('boot', 'boot_first_evt', 3)
    ->addListener('boot', 'boot_not_showed_evt', 1)
    ->addListener('boot:construct', function () {
        echo "<pre>";
        echo 'first things second' . '<br>';
        echo '----------' . '<br>';
        echo "</pre>";
    }, 1)
    ->addListener('boot:construct', function () {
        echo "<pre>";
        echo 'second things first' . '<br>';
        echo '----------' . '<br>';
        echo "</pre>";
    }, 2);
