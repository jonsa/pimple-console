<?php

namespace Jonsa\PimpleConsole;

use Jonsa\PimpleConsole\Event\InitializeConsoleEvent;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Register the console application with the container.
 *
 * @author Jonas Sandström
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param \Pimple\Container $container A container instance
     */
    public function register(Container $container)
    {
        $container['console.name'] = 'Console';
        $container['console.version'] = '1.0';
        $container['console.event_dispatcher'] = null;
        $container['console.enable_xdebug'] = false;

        $container['console'] = function (Container $container) {
            $console = new ConsoleApplication($container['console.name'], $container['console.version']);

            if ($container['console.enable_xdebug'] && function_exists('xdebug_enable')) {
                $definition = $console->getDefinition();
                $definition->addOption(new InputOption(
                    'debug',
                    null,
                    InputOption::VALUE_NONE,
                    'Enable XDebug jit remote mode'
                ));

                $console->setDefinition($definition);

                foreach ($_SERVER['argv'] as $arg) {
                    if ('--debug' === $arg) {
                        poke_xdebug();

                        break;
                    } elseif ('--' === $arg) {
                        break;
                    }
                }
            }

            $dispatcher = $container['console.event_dispatcher'];
            if (is_string($dispatcher)) {
                $dispatcher = $container[$dispatcher];
            }

            if ($dispatcher instanceof EventDispatcherInterface) {
                $console->setDispatcher($dispatcher);

                $dispatcher->dispatch(Events::INIT, new InitializeConsoleEvent($console));
            }

            return $console;
        };
    }
}
