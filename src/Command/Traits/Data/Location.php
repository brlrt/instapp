<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Question\Question;

trait Location
{
    /**
     * Get location ids
     * @return array
     */
    protected function getLocations()
    {
        if ($this->input->getOption('locations'))
        {
            return array_map('trim', explode(',', $this->input->getOption('locations')));
        }

        $locations = [];

        $helper = $this->getHelper('question');

        while (true)
        {
            $question = new Question('<info>Add location id (press <return> to stop adding id): </info>');
            $question->setValidator(
                function($value)
                {
                    if (!empty($value) && !is_numeric($value)) {
                        throw new \InvalidArgumentException('The location id must be numeric');
                    }

                    return $value;
                }
            );
            $location_id = $helper->ask($this->input, $this->output, $question);

            if (empty($location_id))
                break;

            $locations[] = $location_id;
        }

        return $locations;
    }
}