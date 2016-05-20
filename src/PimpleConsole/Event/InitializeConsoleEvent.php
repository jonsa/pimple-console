<?php

namespace Jonsa\PimpleConsole\Event;

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\EventDispatcher\Event;

/**
 * DTO which is dispatched when the console application is resolved out of the
 * container.
 *
 * @author Jonas Sandström
 */
class InitializeConsoleEvent extends Event
{
    /**
     * @var ConsoleApplication
     */
    private $application;

    /**
     * @param ConsoleApplication $application
     */
    public function __construct(ConsoleApplication $application)
    {
        $this->application = $application;
    }

    /**
     * @return ConsoleApplication
     */
    public function getApplication()
    {
        return $this->application;
    }
}
