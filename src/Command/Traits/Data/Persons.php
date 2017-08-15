<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Question\Question;

trait Persons
{
    /**
     * Get persons
     * @param bool $required
     * @return string[]
     */
    protected function getPersons($required = true)
    {
        if ($this->input->getOption('persons'))
        {
            return array_map('trim', explode(',', $this->input->getOption('persons')));
        }

        $persons = [];
        $helper = $this->getHelper('question');

        while (true)
        {
            $question = new Question('<info>Add person username or id (press <return> to stop adding person): </info>');

            $person = $helper->ask($this->input, $this->output, $question);

            if (empty($person) && (count($persons) || !$required))
                break;

            $persons[] = $person;
        }

        return $persons;
    }
}