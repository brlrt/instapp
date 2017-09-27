<?php

namespace Instapp\Event;

use InstagramAPI\Response\Model\User;
use Symfony\Component\EventDispatcher\Event;

class FollowEvent extends Event
{
    const NAME = 'instapp.follow.action';

    /** @var User */
    public $user;

    /** @var bool */
    public $status;

    public function __construct(User $userInfo, $status)
    {
        $this->user = $userInfo;
        $this->status = $status;
    }
}