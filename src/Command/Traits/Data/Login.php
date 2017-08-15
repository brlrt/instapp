<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

trait Login
{
    /**
     * Get account username and password
     * @param bool $useOption
     * @return string|string[]
     */
    protected function getLoginData($useOption = true)
    {
        $username = $this->input->getOption('username');
        $password = $this->input->getOption('password');

        if (!($useOption && $username && $password))
        {
            $helper = $this->getHelper('question');

            $question = new Question('<info>Account username: </info>');
            $question->setValidator(function ($value) { return is_null($value) ?: $value; });

            $username = $helper->ask($this->input, $this->output, $question);

            $question = new Question('<info>Account password: </info>');
            $question->setValidator(function ($value) { return is_null($value) ?: $value; });
            $question->setHidden(true);
            //$question->setHiddenFallback(false);

            $password = $helper->ask($this->input, $this->output, $question);
        }

        return ['username' => $username, 'password' => $password, 'u' => $username, 'p' => $password];
    }
}