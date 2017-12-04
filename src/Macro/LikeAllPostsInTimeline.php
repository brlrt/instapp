<?php

namespace Instapp\Macro;

use Instapp\Macro;

/**
 * Like all posts in timeline
 * @todo like direction (up: like only new feeds / down: like all feeds)
 */
class LikeAllPostsInTimeline extends Macro
{
    public function run()
    {
        $maxId = null;

        do {
            $timeline = $this->app['api']->timeline->getTimelineFeed($maxId);

            foreach ($timeline->getFeedItems() as $item)
            {
                $item = $item->getMediaOrAd();
                if (null !== $item && !$item->getHasLiked())
                {
                    $this->app['like']->likeMedia($item);
                }
            }

            $maxId = $timeline->getNextMaxId();
        }
        while ($maxId !== null);

        return true;
    }
}
