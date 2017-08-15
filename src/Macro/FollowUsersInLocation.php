<?php

namespace Instapp\Macro;

use InstagramAPI\Exception\InstagramException;
use Instapp\Macro;
use Instapp\Macro\FollowContentsOfPost;

class FollowUsersInLocation extends Macro
{
    /** @var integer */
    protected $locationId;

    /**
     * @param $locationId
     * @return $this
     */
    public function setLocation($locationId)
    {
        try {
            $this->app['api']->location->getFeed($locationId);
            $this->locationId = $locationId;
            // todo: test: $ig->request("locations/{$locationId}/related/")

        } catch (InstagramException $e) {

            $this->app['logger']->error("Location not found `{$locationId}`");
            return;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function run()
    {
        if (!$this->locationId) return false;

        $maxId = null;

        do {
            try {
                $location = $this->app['api']->location->getFeed($this->locationId, $maxId);

            } catch (InstagramException $e) {

                $this->app['logger']->error("Location not found `{$this->locationId}`");
                return false;
            }

            foreach ($location->getItems() as $item)
            {
                $this->app['follow']->followContentsOfPost($item, FollowContentsOfPost::ALL ^ FollowContentsOfPost::COMMENT);
            }

            $maxId = $location->getNextMaxId();
        } while ($maxId !== null);

        return true;
    }
}