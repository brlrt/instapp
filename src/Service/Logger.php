<?php

namespace Instapp\Service;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Instapp;
use Instapp\Event\LogEvent;

/**
 * Class Logger
 * @todo log type <info, error, warning>
 */
class Logger
{
    const NORMAL = 'normal';
    const INFO = 'info';
    const ERROR = 'error';
    const TITLE = 'title';
    const FOOTER = 'footer';

    /** @var bool */
    protected $enabled = true;

    /** @var OutputInterface */
    protected $output;

    /** @var Instapp */
    protected $app;

    /** @var string[] */
    protected $type = [null];

    /**
     * Logger constructor.
     */
    public function __construct(Instapp $app)
    {
        $this->app = $app;
        $this->output = new ConsoleOutput();
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function write($message)
    {
        if ($this->enabled)
            $this->output->writeln($message);

        return $this;
    }

    /**
     * @param string|array $message
     * @param string $type
     * @return Logger
     */
    public function add($message = '', $type = self::NORMAL)
    {
        if (is_array($message))
            foreach ($message as $item)
                return $this->add($item, $type);

        if (!empty($message))
            $this->app->dispatcher->dispatch(LogEvent::NAME, new LogEvent($message, $type));

        switch ($type)
        {
            case self::ERROR : $message = "<error>{$message}</error>"; break;
            case self::INFO  : $message = "<info>{$message}</info>"; break;
            case self::TITLE : $message = ["<question>{$message}</question>", str_repeat('=', max(array_map('strlen', (array)$message)))]; break;
            case self::FOOTER: $message = [str_repeat('=', max(array_map('strlen', (array)$message))), "<question>{$message}</question>"]; break;
            case self::NORMAL : break;
            default          : break;
        }

        $this->write($message);

        return $this;
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function error($message)
    {
        return $this->add($message, self::ERROR);
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function info($message)
    {
        return $this->add($message, self::INFO);
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function title($message)
    {
        return $this->add($message, self::TITLE);
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function footer($message)
    {
        return $this->add($message, self::FOOTER);
    }

    /**
     * @param string|array $message
     * @param string $type
     * @return Logger
     */
    public function log($message, $type = self::NORMAL)
    {
        return $this
            ->add()
            ->add($message, $type)
            ->add()
        ;
    }

    /**
     * @param string|array $message
     * @param string $type
     * @return Logger
     */
    public function start($message, $type = self::TITLE)
    {
        $this->type[] = $type;
        return $this->add()->add($message, $type);
    }

    /**
     * @param string|array $message
     * @return Logger
     */
    public function end($message = '')
    {
        $this->add($message, self::FOOTER);

        array_shift($this->type);

        return $this;
    }

    /**
     * Enable logging
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Disable logging
     */
    public function disable()
    {
        $this->enabled = false;
    }
}