<?php

namespace Instapp;

use Pimple\Exception\UnknownIdentifierException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use InstagramAPI\Instagram;
use InstagramAPI\Exception\InstagramException;
use Instapp\Provider\FollowServiceProvider;
use Instapp\Provider\LikeServiceProvider;
use Instapp\Provider\InstagramAPIServiceProvider;
use Instapp\Provider\LoggerServiceProvider;
use Instapp\Provider\UserServiceProvider;
use Instapp\Service\Follow;
use Instapp\Service\Like;
use Instapp\Service\Logger;
use Instapp\Service\User;
use Instapp\Event\LoggedEvent;
use Instapp\Exception\InvalidLoginDataException;
use Instapp\Exception\LoginDataRequiredException;

class Instapp extends \Pimple\Container
{
    /**
     * @var EventDispatcher
     */
    public $dispatcher;

    public function __construct($config = [])
    {
        parent::__construct($config);
        parent::register(new InstagramAPIServiceProvider());
        parent::register(new LoggerServiceProvider());
        parent::register(new UserServiceProvider());
        parent::register(new FollowServiceProvider());
        parent::register(new LikeServiceProvider());

        $this->dispatcher = new EventDispatcher();
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username = null, $password = null)
    {
        if ($username) $this['instagram.username'] = $username;
        if ($password) $this['instagram.password'] = $password;

        try {
            $this['api']->login($this['instagram.username'], $this['instagram.password']);
        } catch (UnknownIdentifierException $e) {
            throw new LoginDataRequiredException("Set username and password");
        } catch (InstagramException $e) {
            throw new InvalidLoginDataException("Username or password incorrect");
        }

        $this->dispatcher->dispatch(LoggedEvent::NAME, new LoggedEvent());
    }

    /**
     * Add listener
     *
     * @param string $name
     * @param callable $listener
     * @param integer $priority
     * @return Instapp
     */
    public function on($name, $listener, $priority = 0)
    {
        $this->dispatcher->addListener($name, $listener, $priority);

        return $this;
    }

    /**
     * @param string $macro
     * @param mixed $args
     * @return mixed
     */
    public function macro($macro, $args)
    {
        $macro = new $macro($this);

        if (!$macro instanceof Macro)
            throw new \InvalidArgumentException('Callable macro class must be instance of Macro.');

        return call_user_func([$macro, 'run'], $args);
    }

    /**
     * IDE Helper
     * @return User|Follow|Logger|Instagram|Like
     */
    public function offsetGet($id)
    {
        return parent::offsetGet($id);
    }
}
