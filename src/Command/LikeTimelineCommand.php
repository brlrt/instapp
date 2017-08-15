<?php

namespace Instapp\Command;

use InstagramAPI\Exception\InstagramException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Command\Traits\Data;

class LikeTimelineCommand extends InstagramCommand
{
    use
        Data\LikeCount,
        Data\WaitTime
    ;

    protected function config()
    {
        $this
            ->setName('like:timeline')
            ->setDescription('Like timeline feeds')
            ->setHelp('Like all posts in timeline')

            ->addOption('max', null, InputArgument::OPTIONAL, 'Max like count')
        ;
    }

    protected function init()
    {
        $this->instapp['like']->maxLikeCount = $this->getLikeCount();
        $this->instapp['like']->waitTime = $this->getWaitTime();

        $this->instapp['like']->likeTimeline();
    }
}