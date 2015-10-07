<?php namespace Jonsa\PimpleConsole;

use Pimple\Container;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Bootstrapper
 *
 * @package Jonsa\PimpleConsole
 * @author Jonas Sandström
 */
final class Builder
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $config = array();

    /**
     * @var array
     */
    private $commands = array();

    /**
     * @var bool
     */
    private $compiled = false;

    /**
     * @param Container $container
     */
    private function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Container|null $container
     * @return Builder
     */
    public static function create(Container $container = null)
    {
        if (null === $container) {
            return new self(new Container());
        }

        return new self($container);
    }

    /**
     * Register the ServiceProvider in the container.
     *
     * @return Container
     */
    public function compile()
    {
        if (!$this->compiled) {
            $this->compiled = true;

            $this->container->register(new ServiceProvider(), $this->config);
            $this->container->offsetGet('console')->addCommands($this->commands);
        }

        return $this->container;
    }

    /**
     * Run the console application.
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function run()
    {
        return $this->compile()->offsetGet('console')->run();
    }

    /**
     * Set the console application name.
     *
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        $this->config['console.name'] = $name;

        return $this;
    }

    /**
     * Set the console application version.
     *
     * @param string $version
     * @return $this
     */
    public function version($version)
    {
        $this->config['console.version'] = $version;

        return $this;
    }

    /**
     * Set the event dispatcher. Either a dispatcher instance or a string where
     * a dispatcher can be found in the container.
     *
     * @param string|EventDispatcherInterface $dispatcher
     * @return $this
     */
    public function dispatcher($dispatcher)
    {
        if (!is_string($dispatcher) && !$dispatcher instanceof EventDispatcherInterface) {
            throw new \InvalidArgumentException(
                'Dispatcher needs to be a string or an instance of EventDispatcherInterface'
            );
        }

        $this->config['console.event_dispatcher'] = $dispatcher;

        return $this;
    }

    /**
     * Enable XDebug support. Adds the --debug option to all commands.
     *
     * @param bool $enable
     * @return $this
     */
    public function xdebug($enable = true)
    {
        $this->config['console.enable_xdebug'] = (bool)$enable;

        return $this;
    }

    /**
     * Add a command to the console application.
     *
     * @param SymfonyCommand $command
     * @return $this
     */
    public function add(SymfonyCommand $command)
    {
        if ($this->compiled) {
            $this->container['console']->add($command);
        } else {
            $this->commands[] = $command;
        }

        return $this;
    }

    /**
     * Enable XDebug jit mode and trigger XDebug by calling a suppressed trigger_error.
     *
     * @return $this
     */
    public function poke()
    {
        poke_xdebug();

        return $this;
    }

}
