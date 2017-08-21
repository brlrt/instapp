<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Question\Question;

trait WaitTime
{
    /**
     * @var int
     */
    protected $waitTime = 20;

    /**
     * Set wait time after process
     * @param integer $default
     * @return integer
     */
    protected function getWaitTime($default = null)
    {
        if ($this->input->getOption('wait'))
            return $this->input->getOption('wait');

        $default = $default ?: ($this->waitTime ?: 0);

        $helper = $this->getHelper('question');

        $question = new Question("<info>Wait time({$default}): </info>", $default);

        return $helper->ask($this->input, $this->output, $question);
    }
}