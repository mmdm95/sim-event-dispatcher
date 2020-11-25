# Simplicity Event Dispatcher
A library for event management.

## Install
**composer**
```php 
composer require mmdm/sim-event-dispatcher
```

Or you can simply download zip file from github and extract it, 
then put file to your project library and use it like other libraries.

Just add line below to autoload files:

```php
require_once 'path_to_library/autoloader.php';
```

and you are good to go.

## How to use
```php
// we need event provider to add events to that
$event_provider = new EventProvider();

// also we need closure provider to add closures to that
$closure_provider = new ClosureProvider();

// then use their methods
$event_provider->addEvent(new Event('boot'))
    ->addEvent(new Event('close'));
//-----
$closure_provider->addClosure($nameOfClosureOrKey, function () {
    // define closure functionality
});

// to instanciate an emitter object,
// use event provider and closure provider,
// from above
$emitter = new Emitter($event_provider, $closure_provider);

// now work with listeners
$emitter->addListener($nameOfEvent, $nameOfClosureOrKey);
$emitter->removeListener($nameOfEvent, $nameOfClosureOrKey);

// finally dispatch event where you want
$emitter->dispatch($nameOfEvent);
```

## Available functions

#### EventProvider

- addEvent(IEvent $event): IEventProvider

This method add an event to the provider

```php
// to add an event
$event_provider->addEvent(new Event('cartOnBoot'));
```

- removeEvent(string $event_name): IEventProvider

This method remove an event from the provider

```php
// to remove an event
$event_provider->removeEvent('cartOnBoot');
```

- getEvent(string $event_name): IEvent

This method gets an event from the provider

```php
// to get an event
$event_provider->getEvent('cartOnBoot');
```

- hasEvent(string $event_name): bool

This method checks to see if an event is exist in provider

```php
// check if an event exists
$event_provider->hasEvent('cartOnBoot');
```

#### ClosureProvider

- addClosure($key, $closure): IClosureProvider

This method add a closure to provider

```php
// to add a closure
$closure_provider->addClosure($closureKeyOrName, function () {
    // define closure functionality
});
```

- removeClosure($key): IClosureProvider

This method removes a closure from provider

```php
// to remove a closure
$closure_provider->removeClosure($closureKeyOrName);
```

- getClosure($key): Closure

This method gets a closure from provider

```php
// to get a closure
$closure_provider->getClosure($closureKeyOrName);
```

- hasClosure($key): bool

This method checks to see if a closure is exist in provider

```php
// check if a closure exists
$closure_provider->hasClosure('cartOnBoot');
```

#### Emitter

- addListener(string $event_name, string $closure_name, int $priority = 0): IEmitter

This method add a listener to emitter

Note: If you need some listeners to emit faster than others, 
then you should pass priority as a number.(Higher value means higher priority)

```php
// to add a listener
$emitter->addListener('cartOnBoot', 'cart_boot');
// or with a higher priority
$emitter->addListener('cartOnBoot', 'cart_boot', 5);
```

- removeListener(string $event_name, string $closure_name): IEmitter

This method removes a listener from emitter

```php
// to remove a listener
$emitter->removeListener('cartOnBoot', 'cart_boot');
```

- removeAllListeners(string $event_name): IEmitter

This method remove all listeners of an event from emitter

```php
// to remove a listener
$emitter->removeAllListeners('cartOnBoot');
```

- getListener(string $event_name): array

This method gets all listeners of an event from emitter

```php
// to get all listeners of an event
$emitter->getListener('cartOnBoot');
```

- getAllListeners(): array

This method gets all listeners from emitter

```php
// to get all listeners
$emitter->getAllListeners();
```

# License
Under MIT license.