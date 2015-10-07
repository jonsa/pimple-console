<?php namespace Jonsa\PimpleConsole\Test\Data;

use Jonsa\PimpleConsole\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class FooCommand extends Command
{

    protected $name = 'name';

    protected $description = 'description';

    protected $help = 'help';


    protected function handle()
    {
    }

    protected function getArguments()
    {
        return array(
            array(
                'arg',
                InputArgument::OPTIONAL,
                'optional argument',
                'default' => 'foo',
            ),
        );
    }

    protected function getOptions()
    {
        return array(
            array(
                'opt',
                'o',
                InputOption::VALUE_OPTIONAL,
                'optional option',
                'default' => 'bar',
            )
        );
    }


}
