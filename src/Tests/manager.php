<?php

use Sim\Event\Emitter;
use Sim\Event\Event;

include_once '../../vendor/autoload.php';

$emitter = new Emitter();
$boot_evt = new Event('boot');
// define events' callback
$emitter->addListener($boot_evt, function (Event $event) {
    echo $event->getName() . ': This event goes later' . PHP_EOL;
    echo '----------' . PHP_EOL;
    return false;
}, 2)->addListener(new Event('close'), function (Event $event) {
    echo $event->getName() . ': Event emitted' . PHP_EOL;
    echo '----------' . PHP_EOL;
}, 3);
$emitter->addListener($boot_evt, function (Event $event) {
    echo $event->getName() . ': This event goes first' . PHP_EOL;
    echo '----------' . PHP_EOL;
    return 'hi';
}, 3);
$emitter->addListener($boot_evt, function (Event $event) {
    echo $event->getName() . ': This event never displayed!' . PHP_EOL;
    echo '----------' . PHP_EOL;
}, 1);
