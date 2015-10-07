<?php namespace Jonsa\PimpleConsole\Test;

use Jonsa\PimpleConsole\Test\Data\FooCommand;
use Jonsa\PimpleConsole\Test\Data\RawOutputFormatter;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class CommandTest
 *
 * @package Jonsa\PimpleConsole\Test
 * @author Jonas Sandström
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicCommandInformation()
    {
        $command = new FooCommand();
        $command->run(new ArrayInput(array()), new NullOutput());

        $this->assertEquals('name', $command->getName());
        $this->assertEquals('description', $command->getDescription());
        $this->assertEquals('help', $command->getHelp());
        $this->assertEquals('foo', $command->argument('arg'));
        $this->assertEquals('bar', $command->option('opt'));
    }

    public function testOutputFormatting()
    {
        $console = new ConsoleApplication();
        $console->add($command = new FooCommand());

        $command->run(new ArrayInput(array('')), $output = new BufferedOutput());
        $output->setFormatter(new RawOutputFormatter());

        $command->line('foo');
        $this->assertEquals('foo', rtrim($output->fetch()));

        $command->info('foo');
        $this->assertEquals('<info>foo</info>', rtrim($output->fetch()));

        $command->comment('foo');
        $this->assertEquals('<comment>foo</comment>', rtrim($output->fetch()));

        $command->question('foo');
        $this->assertEquals('<question>foo</question>', rtrim($output->fetch()));

        $command->error('foo');
        $this->assertEquals('<error>foo</error>', rtrim($output->fetch()));
    }

    public function testQuestion()
    {
        /** @var \Symfony\Component\Console\Helper\HelperInterface|\PHPUnit_Framework_MockObject_MockObject $helper */
        $helper = $this->getMock('Symfony\\Component\\Console\\Helper\\QuestionHelper', array('ask'));
        $helper->expects($this->once())
            ->method('ask')
            ->willReturn('foo');

        $console = new ConsoleApplication();
        $console->add($command = new FooCommand());

        $command->getHelperSet()->set($helper, 'question');
        $command->run(new ArrayInput(array('')), new NullOutput());

        $this->assertEquals('foo', $command->ask('test'));
    }

}
