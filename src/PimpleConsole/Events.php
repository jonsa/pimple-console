<?php

namespace Jonsa\PimpleConsole;

/**
 * Placeholder object for event names.
 *
 * @author Jonas Sandström
 */
final class Events
{
    /**
     * The INIT event occurs when the console application is resolved
     * out of the pimple container. This is a good place to register
     * commands.
     *
     * @var string
     */
    const INIT = 'jonsa.pimple_console.init';

    /**
     * 
     */
    private function __construct()
    {
    }
}
