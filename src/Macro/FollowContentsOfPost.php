<?php

namespace Instapp\Macro;

use InstagramAPI\Response\Model\Item;
use Instapp\Macro;

/**
 * Follow users in contents of post
 */
class FollowContentsOfPost extends Macro
{
    const OWNER = 1;
    const USERTAG = 2;
    const COMMENT = 4;
    const ALL = 7;

    /** @var Item */
    protected $post;

    /**
     * @param Item $post
     * @return $this
     */
    public function setItem(Item $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @param int $followField
     * @return bool
     */
    public function run($followField = self::ALL)
    {
        if (self::OWNER & $followField)
        {
            $this->app['follow']->followUser($this->post->getUser());
        }

        if ((self::USERTAG & $followField) && $this->post->getUsertags())
        {
            foreach ($this->post->getUsertags()->getIn() as $tag)
            {
                $this->app['follow']->followUser($tag->getUser());
            }
        }

        if ((self::COMMENT & $followField) && $this->post->getHasMoreComments())
        {
            foreach ($this->post->getPreviewComments() as $comment)
            {
                $this->app['follow']->followUser($comment->getUser());
            }
        }

        return true;
    }
}