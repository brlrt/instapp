<?php

namespace Instapp\Service;

use Instapp\Event\FollowEvent;
use Instapp\Macro\FollowUsersInLocation;
use Instapp\Exception\MaxFollowCountException;
use Instapp\Instapp;
use InstagramAPI\Response\Model\Item;
use Instapp\Macro\FollowContentsOfPost;
use Instapp\Macro\FollowUserFollowers;
use Instapp\Traits\Wait;
use Instapp\Macro\FollowUsersInHashtag;

class Follow
{
    use Wait;

    /**
     * Already following users and followers
     * @var array
     */
    protected $requestedUsers = [];

    /**
     * @var int
     */
    protected $followCount = 0;

    /**
     * @var int
     */
    public $maxFollowCount = 500;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * @var Instapp
     */
    protected $app;

    /**
     * Follow constructor.
     * @param Instapp $app
     */
    public function __construct(Instapp $app)
    {
        $this->app = $app;

        $this->startedAt = new \DateTime();

        $this->takeRequested();
    }

    /**
     * Follow a user
     * @param mixed $user
     * @throws MaxFollowCountException
     */
    public function followUser($user)
    {
        if ($this->isRequested($user))
            return;

        if ($this->followCount >= $this->maxFollowCount)
        {
            try {
                throw new MaxFollowCountException("Max follow count ({$this->maxFollowCount}) was reached.");
            } catch (MaxFollowCountException $e) {
                $this->app['logger']->add($e->getMessage());
                return;
            } finally {
                $this->status();
            }
        }

        $userId = $this->app['user']->getIdFromUserdata($user);

        $this->app['api']->people->follow($userId);

        $this->app->dispatcher->dispatch(FollowEvent::NAME, new FollowEvent($this->app['api']->people->getInfoById($userId)->user, true));

        $this->app['logger']
            ->add(
                sprintf(
                    '(%s) `%s` - followed!',
                    ++$this->followCount,
                    $this->app['user']->getUsername($user)
                )
            )
        ;

        $this->addRequested($user);
        $this->wait();
    }

    /**
     * @return array
     */
    public function status()
    {
        $result = [
            'followed'  => $this->followCount,
            'time'      => (new \DateTime())->diff($this->startedAt)
        ];

        $this->app['logger']->end(sprintf(
            '%s user requested in %s hours, %s minutes',
            $result['followed'],
            $result['time']->h,
            $result['time']->i
        ));

        return $result;
    }

    /**
     * @param mixed $user
     * @return bool
     */
    public function isRequested($user)
    {
        return isset($this->requestedUsers[$this->app['user']->getUsernameFromUserdata($user)]);
    }

    /**
     * Add requested user
     * @param mixed $user
     */
    public function addRequested($user)
    {
        $this->requestedUsers[$this->app['user']->getUsernameFromUserdata($user)] = true;
    }

    /**
     * Get requested users
     * @return array
     */
    public function getRequested()
    {
        return array_keys($this->requestedUsers);
    }

    /**
     * Take following users and followers
     */
    private function takeRequested()
    {
        foreach (
            array_merge(
                $this->app['api']->people->getSelfFollowers()->users,
                $this->app['api']->people->getSelfFollowing()->users
            ) as $user
        ) {
            $this->addRequested($user);
        }
    }

    # MACROS

    /**
     * Follow users in contents of post
     * @param Item $post
     * @param integer $field
     * @return bool
     */
    public function followContentsOfPost(Item $post, $field = FollowContentsOfPost::ALL)
    {
        return (new FollowContentsOfPost($this->app))
            ->setItem($post)
            ->run($field)
        ;
    }

    /**
     * @param integer $locationId
     * @return bool
     */
    public function followUsersInLocation($locationId)
    {
        return (new FollowUsersInLocation($this->app))
            ->setLocation($locationId)
            ->run()
        ;
    }

    /**
     * @param integer $hashtag
     * @return bool
     */
    public function followUsersInHashtag($hashtag)
    {
        return (new FollowUsersInHashtag($this->app))
            ->setHashtag($hashtag)
            ->run()
        ;
    }

    /**
     * @param mixed $user
     * @return bool
     */
    public function followUserFollowers($user)
    {
        return (new FollowUserFollowers($this->app))
            ->setUser($user)
            ->run()
        ;
    }
}