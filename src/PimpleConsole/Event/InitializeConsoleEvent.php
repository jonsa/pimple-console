<?php namespace Jonsa\PimpleConsole\Event;

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class InitializeConsoleEvent
 *
 * @package Jonsa\PimpleConsole
 * @author Jonas Sandström
 */
class InitializeConsoleEvent extends Event
{

    /**
     * @var ConsoleApplication
     */
    private $application;

    function __construct(ConsoleApplication $application)
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
