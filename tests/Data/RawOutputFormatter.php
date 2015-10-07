<?php namespace Jonsa\PimpleConsole\Test\Data;

use Symfony\Component\Console\Formatter\OutputFormatter;

class RawOutputFormatter extends OutputFormatter
{
    public function format($message)
    {
        return $message;
    }
}
