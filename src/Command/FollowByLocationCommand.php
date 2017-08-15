<?php

namespace Instapp\Command;

use InstagramAPI\Exception\InstagramException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Command\Traits\Data;

class FollowByLocationCommand extends InstagramCommand
{
    use
        Data\Location,
        Data\FollowCount,
        Data\WaitTime
    ;

    protected function config()
    {
        $this
            ->setName('follow:location')
            ->setDescription('Follow users by location')
            ->setHelp('Follow all users in a location')

            ->addOption('max', null, InputArgument::OPTIONAL, 'Max follow count')
            ->addOption('locations', null, InputArgument::OPTIONAL, 'Location ids (commas)')
        ;
    }

    protected function init()
    {
        $locations = $this->getLocations();

        $this->instapp['follow']->waitTime = $this->getWaitTime();
        $this->instapp['follow']->maxFollowCount = $this->getFollowCount();

        foreach ($locations as $locationId)
        {
            $this->instapp['follow']->followUsersInLocation($locationId);
        }
    }
}