<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Question\Question;

trait LikeCount
{
    /**
     * Set wait time after process
     * @param integer $default
     * @return integer
     */
    protected function getLikeCount($default = null)
    {
        if ($this->input->getOption('max'))
            return $this->input->getOption('max');

        $default = $default ?: 500;

        $helper = $this->getHelper('question');

        $question = new Question("<info>Max like count ({$default}): </info>", $default);

        return $helper->ask($this->input, $this->output, $question);
    }
}