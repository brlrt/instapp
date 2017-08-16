<?php

namespace Instapp\Command;

use InstagramAPI\Exception\InstagramException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Command\Traits\Data;

class FollowByHashtagCommand extends InstagramCommand
{
    use
        Data\Hashtag,
        Data\FollowCount,
        Data\WaitTime
    ;

    protected function config()
    {
        $this
            ->setName('follow:hashtag')
            ->setDescription('Follow users by hashtag')
            ->setHelp('Follow all users in hashtag')

            ->addOption('max', null, InputArgument::OPTIONAL, 'Max follow count')
            ->addOption('hashtags', null, InputArgument::OPTIONAL, 'Hashtags (commas)')
        ;
    }

    protected function init()
    {
        $hashtags = $this->getHashtags();

        $this->instapp['follow']->waitTime = $this->getWaitTime();
        $this->instapp['follow']->maxFollowCount = $this->getFollowCount();

        foreach ($hashtags as $hashtag)
        {
            $this->instapp['follow']->followUsersInHashtag($hashtag);
        }
    }
}