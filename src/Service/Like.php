<?php

namespace Instapp\Service;

use InstagramAPI\Response\Model\Item;
use Instapp\Event\LikeEvent;
use Instapp\Instapp;
use Instapp\Traits\Wait;
use Instapp\Macro\LikeAllPostsInTimeline;
use Instapp\Exception\MaxLikeCountException;

class Like
{
    use Wait;

    /**
     * @var int
     */
    protected $likeCount = 0;

    /**
     * @var int
     */
    public $maxLikeCount = 1000;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * @var Instapp
     */
    protected $app;

    /**
     * Like constructor.
     * @param Instapp $app
     */
    public function __construct(Instapp $app)
    {
        $this->app = $app;
        $this->startedAt = new \DateTime();
    }

    /**
     * @param Item $item
     */
    public function likeMedia(Item $item)
    {
        if ($this->likeCount >= $this->maxLikeCount)
        {
            try {
                throw new MaxLikeCountException("Max like count ({$this->maxLikeCount}) was reached.");
            } catch (MaxLikeCountException $e) {
                $this->app['logger']->add($e->getMessage());
                return;
            } finally {
                $this->status();
                return;
            }
        }

        $this->app['api']->media->like($item->getId());

        $this->app->dispatcher->dispatch(LikeEvent::NAME, new LikeEvent($item, true));

        $this->app['logger']->add(sprintf(
            '(%s) - `%s - instagram.com/p/%s` - liked!',
            ++$this->likeCount,
            $item->getUser()->getUsername(),
            $item->getCode()
        ));

        $this->wait();
    }

    /**
     * @return array
     */
    public function status()
    {
        $result = [
            'liked'     => $this->likeCount,
            'time'      => (new \DateTime())->diff($this->startedAt)
        ];

        $this->app['logger']->end(sprintf(
            '%s post liked in %s hours, %s minutes',
            $result['liked'],
            $result['time']->h,
            $result['time']->i
        ));

        return $result;
    }

    # MACROS

    public function likeTimeline()
    {
        $this->app['logger']->start('Scrolling down :)');
        return (new LikeAllPostsInTimeline($this->app))->run();
    }
}