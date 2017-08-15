<?php

namespace Instapp\Macro;

use Instapp\Macro;

class FollowUserFollowers extends Macro
{
    /** @var integer */
    protected $userId;

    /**
     * @param mixed $user
     * @return $this
     */
    public function setUser($user)
    {
        if (!( $this->userId = $this->app['user']->getIdFromUserdata($user) ))
        {
            $this->app['logger']->error("Person `{$user}` not found.");
            return;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function run()
    {
        if (!$this->userId) return false;

        foreach ($this->app['api']->people->getFollowers($this->userId)->users as $user)
        {
            $this->app['follow']->followUser($user);
        }

        return true;
    }
}