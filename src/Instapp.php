<?php

namespace Instapp;

use InstagramAPI\Instagram;
use Instapp\Provider\FollowServiceProvider;
use Instapp\Provider\LikeServiceProvider;
use Instapp\Provider\InstagramAPIServiceProvider;
use Instapp\Provider\LoggerServiceProvider;
use Instapp\Provider\UserServiceProvider;
use Instapp\Service\Follow;
use Instapp\Service\Like;
use Instapp\Service\Logger;
use Instapp\Service\User;
use Instapp\Exception\InvalidLoginDataException;
use Instapp\Exception\LoginDataRequiredException;
use InstagramAPI\Exception\InstagramException;
use Pimple\Exception\UnknownIdentifierException;

class Instapp extends \Pimple\Container
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        parent::register(new InstagramAPIServiceProvider());
        parent::register(new LoggerServiceProvider());
        parent::register(new UserServiceProvider());
        parent::register(new FollowServiceProvider());
        parent::register(new LikeServiceProvider());
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
     * Set callback
     *
     * @param string $name
     * @param callable $callback
     * @return Instapp
     */
    public function on($name, $callback)
    {
        $this->offsetSet("callback:{$name}", $callback);

        return $this;
    }

    /**
     * Get callback
     *
     * @param $name
     * @return callable
     */
    public function getCallback($name)
    {
        try {
            return $this->offsetGet("callback:$name}");
        } catch (UnknownIdentifierException $e) {
            return null;
        }
    }

    /**
     * Clear callback
     *
     * @param string $name
     * @return Instapp
     */
    public function clearCallback($name)
    {
        $this->offsetUnset("callback:{$name}");

        return $this;
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

