# Pimple Console ServiceProvider

## Installation
Add the console provider to your ```composer.json``` using the command line.
```
composer require jonsa/pimple-console
```

## Configuration
```php
use Pimple\Container;
use Jonsa\PimpleConsole\ServiceProvider;

$container = new Container();
$container->register(new ServiceProvider(), array(
    /**
     * Set the console application name. Defaults to 'Console'
     * @param string
     */
    'console.name' => 'My Console Application',
    /**
     * Set the console application version. Defaults to '1.0'
     * @param string
     */
    'console.version' => '2.0',
    /**
     * Set the event dispatcher. Either a dispatcher instance or a string where
     * a dispatcher can be found in the container.
     * @param string|\Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    'console.event_dispatcher' => new \Symfony\Component\EventDispatcher\EventDispatcher(),
    /**
     * Set XDebug in jit mode. Adds the --debug option to all commands.
     * Only applicable if XDebug is available.
     * @param bool
     */
    'console.enable_xdebug' => true,
));
```

## Usage
Create a script in your project and setup the Pimple container manually.
```php
#!/usr/bin/env php
<?php

require '[path to composer vendor folder]/autoload.php';

$container = new \Pimple\Container();
$container->register(new \Jonsa\PimpleConsole\ServiceProvider(), array(
    'console.name' => 'Console Application'
));

$console = $container['console'];
$console->add(new MyCommand());
$console->run();
```

Alternatively use the provided builder to setup the console application.
```php
#!/usr/bin/env php
<?php

require '[path to composer vendor folder]/autoload.php';

\Jonsa\PimpleConsole\Builder::create()
    ->name('Console Application')
    ->add(new MyCommand())
    ->run();
```

## Register commands using event listener
```php
use Jonsa\PimpleConsole\Builder;
use Jonsa\PimpleConsole\Event\InitializeConsoleEvent;
use Jonsa\PimpleConsole\Events;
use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();
$dispatcher->addListener(Events::INIT, function (InitializeConsoleEvent $event) {
    $event->getApplication()->add(new MyCommand('my'));
});

Builder::create()
    ->name('Console Application')
    ->dispatcher($dispatcher)
    ->run();
```

## XDebug convenience
This requires the XDebug module to be enabled.

To simplify debugging of console applications there is a built in ```--debug``` option that can be enabled.

If enabled and the command is called with the ```--debug``` option XDebug will be set into ```jit``` mode and triggered with a suppressed ```trigger_error```.

Optionally the same can be achieved by calling the ```poke_xdebug()``` helper function at a specific place in your code.
