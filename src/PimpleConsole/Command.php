<?php namespace Jonsa\PimpleConsole;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class Command
 *
 * @package Jonsa\PimpleConsole
 * @author Jonas Sandström
 */
abstract class Command extends SymfonyCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help = null;

    /**
     * The input interface implementation.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * The output interface implementation.
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * Main entry point into the command.
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected abstract function handle();

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        if ($this->name) {
            $this->setName($this->name);
        }

        if ($this->description) {
            $this->setDescription($this->description);
        }

        if ($this->help) {
            $this->setHelp($this->help);
        }

        foreach ($this->getArguments() as $arguments) {
            call_user_func_array(array(
                $this,
                'addArgument'
            ), $arguments);
        }

        foreach ($this->getOptions() as $options) {
            call_user_func_array(array(
                $this,
                'addOption'
            ), $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        return parent::run($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this::handle();
    }


    /**
     * Get the console command arguments.
     *
     * @return array An array of arrays containing arguments matching the addArgument method
     * @see \Symfony\Component\Console\Command::addArgument()
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array An array of arrays containing arguments matching the addOption method
     * @see \Symfony\Component\Console\Command::addOption()
     */
    protected function getOptions()
    {
        return array();
    }

    /**
     * Get the value of a command argument.
     *
     * @param string $key
     *
     * @return string|array
     */
    public function argument($key = null)
    {
        if (is_null($key)) return $this->input->getArguments();

        return $this->input->getArgument($key);
    }

    /**
     * Get the value of a command option.
     *
     * @param string $key
     *
     * @return string|array
     */
    public function option($key = null)
    {
        if (is_null($key)) return $this->input->getOptions();

        return $this->input->getOption($key);
    }

    /**
     * Call another console command.
     *
     * @param string $command
     * @param array $arguments
     *
     * @return int
     */
    public function call($command, array $arguments = array())
    {
        $instance = $this->getApplication()->find($command);

        $arguments['command'] = $command;

        return $instance->run(new ArrayInput($arguments), $this->output);
    }

    /**
     * Call another console command silently.
     *
     * @param string $command
     * @param array $arguments
     *
     * @return int
     */
    public function callSilent($command, array $arguments = array())
    {
        $instance = $this->getApplication()->find($command);

        $arguments['command'] = $command;

        return $instance->run(new ArrayInput($arguments), new NullOutput());
    }

    /**
     * Write a string as standard output.
     *
     * @param string $string
     *
     * @return void
     */
    public function line($string)
    {
        $this->output->writeln($string);
    }

    /**
     * Write a string as information output.
     *
     * @param string $string
     *
     * @return void
     */
    public function info($string)
    {
        $this->output->writeln("<info>$string</info>");
    }

    /**
     * Write a string as comment output.
     *
     * @param string $string
     *
     * @return void
     */
    public function comment($string)
    {
        $this->output->writeln("<comment>$string</comment>");
    }

    /**
     * Write a string as question output.
     *
     * @param string $string
     *
     * @return void
     */
    public function question($string)
    {
        $this->output->writeln("<question>$string</question>");
    }

    /**
     * Write a string as error output.
     *
     * @param string $string
     *
     * @return void
     */
    public function error($string)
    {
        $this->output->writeln("<error>$string</error>");
    }

    /**
     * Confirm a question with the user.
     *
     * @param string $question The question to ask to the user
     * @param bool $default The default answer to return, true or false
     * @param string $trueAnswerRegex A regex to match the "yes" answer
     *
     * @return bool
     */
    public function confirm($question, $default = false, $trueAnswerRegex = '/^y/i')
    {
        $question = new ConfirmationQuestion(
            "<question>{$question}</question> ",
            $default,
            $trueAnswerRegex
        );

        return $this->getHelper('question')
            ->ask($this->input, $this->output, $question);
    }

    /**
     * Prompt the user for input.
     *
     * @param string $question The question to ask to the user
     * @param mixed $default The default answer to return if the user enters nothing
     *
     * @return string
     */
    public function ask($question, $default = null)
    {
        $question = new Question("<question>$question</question> ", $default);

        return $this->getHelper('question')
            ->ask($this->input, $this->output, $question);
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param string $question The question to ask to the user
     * @param array $choices The list of available choices
     * @param mixed $default The default answer to return
     * @param mixed $attempts
     * @param bool $multiple
     *
     * @return mixed
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        $question = new ChoiceQuestion("<question>$question</question> ", $choices, $default);
        $question->setMultiselect($multiple)->setMaxAttempts($attempts);

        return $this->getHelper('question')
            ->ask($this->input, $this->output, $question);
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param string $question The question to ask to the user
     * @param null|array|\Traversable $choices
     * @param mixed $default The default answer to return if the user enters nothing
     *
     * @return string
     */
    public function askWithCompletion($question, array $choices, $default = null)
    {
        $question = new Question("<question>$question</question> ", $default);
        $question->setAutocompleterValues($choices);

        return $this->getHelper('question')
            ->ask($this->input, $this->output, $question);
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param string $question The question to ask to the user
     * @param bool $fallback
     *
     * @return string
     */
    public function secret($question, $fallback = true)
    {
        $question = new Question("<question>$question</question> ");
        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->getHelper('question')
            ->ask($this->input, $this->output, $question);
    }

    /**
     * Format input to textual table.
     *
     * @param array $headers
     * @param array $rows
     * @param string $style
     *
     * @return void
     */
    public function table(array $headers, array $rows, $style = 'default')
    {
        $table = new Table($this->output);

        $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();
    }

}
