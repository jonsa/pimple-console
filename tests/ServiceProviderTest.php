<?php namespace Jonsa\PimpleConsole\Test;

use Jonsa\PimpleConsole\Events;
use Jonsa\PimpleConsole\ServiceProvider;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ServiceProviderTest
 *
 * @package Jonsa\PimpleConsole\Test
 * @author Jonas Sandström
 */
class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testConfigurationParameters()
    {
        $container = new Container();
        $container->register(new ServiceProvider(), array(
            'console.name' => 'MyApp',
            'console.version' => '2.0',
        ));

        /** @var \Symfony\Component\Console\Application $console */
        $console = $container['console'];
        $this->assertInstanceOf('Symfony\\Component\\Console\\Application', $console);

        $this->assertEquals('MyApp', $console->getName());
        $this->assertEquals('2.0', $console->getVersion());
    }

    public function testEventDispatcher()
    {
        $dispatcher = $this->getMockForAbstractClass(
            'Symfony\\Component\\EventDispatcher\\EventDispatcherInterface'
        );
        $dispatcher->expects($this->once())
            ->method('dispatch');

        $container = new Container();
        $container['dispatcher'] = function () use ($dispatcher) {
            return $dispatcher;
        };

        $container->register(new ServiceProvider(), array(
            'console.event_dispatcher' => 'dispatcher',
        ));

        $container['console'];
    }

    public function testInitializeEvent()
    {
        $called = 0;
        $that = $this;

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(Events::INIT, function ($event) use ($that, &$called) {
            $that->assertInstanceOf('Jonsa\\PimpleConsole\\Event\\InitializeConsoleEvent', $event);
            $called++;
        });

        $container = new Container();
        $container->register(new ServiceProvider());
        $container['console.event_dispatcher'] = $dispatcher;

        $container['console'];
        $this->assertEquals(1, $called);
    }

    public function testItPokesXDebugWhenDebugFlagIsUsed()
    {
        if (!function_exists('xdebug_enable')) {
            $this->markTestSkipped('XDebug is not present');
        }

        $message = '';
        $backup = $_SERVER['argv'];

        set_error_handler(function ($errno, $errstr) use (&$message) {
            $message = $errstr;
        });

        $_SERVER['argv'][] = '--debug';

        $container = new Container();
        $container->register(new ServiceProvider(), array(
            'console.enable_xdebug' => true,
        ));

        $container['console'];

        restore_error_handler();
        $_SERVER['argv'] = $backup;

        $this->assertEquals("I'm poking that bear!", $message);
    }

    public function testItDoesNotPokeXDebugWhenDebugFlagIsAfterEndOfOptions()
    {
        if (!function_exists('xdebug_enable')) {
            $this->markTestSkipped('XDebug is not present');
        }

        $message = '';
        $backup = $_SERVER['argv'];

        set_error_handler(function ($errno, $errstr) use (&$message) {
            $message = $errstr;
        });

        $_SERVER['argv'][] = '--';
        $_SERVER['argv'][] = '--debug';

        $container = new Container();
        $container->register(new ServiceProvider(), array(
            'console.enable_xdebug' => true,
        ));

        $container['console'];

        restore_error_handler();
        $_SERVER['argv'] = $backup;

        $this->assertEquals('', $message);
    }

}
