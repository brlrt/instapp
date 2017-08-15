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
            $this->app['follow']->followUser($this->post->user);
        }

        if ((self::USERTAG & $followField) && $this->post->usertags)
        {
            foreach ($this->post->usertags->getIn() as $tag)
            {
                $this->app['follow']->followUser($tag->user);
            }
        }

        if ((self::COMMENT & $followField) && $this->post->has_more_comments)
        {
            foreach ($this->post->preview_comments as $comment)
            {
                $this->app['follow']->followUser($comment->user);
            }
        }

        return true;
    }
}