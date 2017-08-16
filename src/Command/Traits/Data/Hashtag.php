<?php

namespace Instapp\Command\Traits\Data;

use Symfony\Component\Console\Question\Question;

trait Hashtag
{
    /**
     * Get hashtag ids
     * @return array
     */
    protected function getHashtags()
    {
        if ($this->input->getOption('hashtags'))
        {
            return array_map('trim', explode(',', $this->input->getOption('hashtags')));
        }

        $hashtags = [];

        $helper = $this->getHelper('question');

        while (true)
        {
            $question = new Question('<info>Add hashtag (press <return> to stop adding): </info>');
            $hashtag = $helper->ask($this->input, $this->output, $question);

            if (empty($hashtag))
                break;

            $hashtags[] = $hashtag;
        }

        return $hashtags;
    }
}