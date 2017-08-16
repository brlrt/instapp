<?php

namespace Instapp\Macro;

use InstagramAPI\Exception\InstagramException;
use Instapp\Macro;
use Instapp\Macro\FollowContentsOfPost;

class FollowUsersInHashtag extends Macro
{
    /** @var string */
    protected $hashtag;

    /**
     * @param $hashtag
     * @return $this
     */
    public function setHashtag($hashtag)
    {
        try {
            $this->app['api']->hashtag->getFeed($hashtag);
            $this->hashtag = $hashtag;

        } catch (InstagramException $e) {

            $this->app['logger']->error("Hashtag not found `{$hashtag}`");
            return;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function run()
    {
        if (!$this->hashtag) return false;

        $maxId = null;

        do {
            try {
                $feed = $this->app['api']->hashtag->getFeed($this->hashtag, $maxId);

            } catch (InstagramException $e) {

                $this->app['logger']->error("Hashtag not found `{$this->hashtag}`");
                return false;
            }

            foreach ($feed->getItems() as $item)
            {
                $this->app['follow']->followContentsOfPost($item, FollowContentsOfPost::ALL ^ FollowContentsOfPost::COMMENT);
            }

            $maxId = $feed->getNextMaxId();
        } while ($maxId !== null);

        return true;
    }
}