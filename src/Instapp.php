<?php

namespace Instapp;

use InstagramAPI\Exception\InstagramException;
use InstagramAPI\Instagram;
use Instapp\Exception\InvalidLoginDataException;
use Instapp\Exception\LoginDataRequiredException;
use Instapp\Provider\FollowServiceProvider;
use Instapp\Provider\LikeServiceProvider;
use Instapp\Provider\InstagramAPIServiceProvider;
use Instapp\Provider\LoggerServiceProvider;
use Instapp\Provider\UserServiceProvider;
use Instapp\Service\Follow;
use Instapp\Service\Like;
use Instapp\Service\Logger;
use Instapp\Service\User;

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

        if (!$this['instagram.username'] || !$this['instagram.password'])
        {
            throw new LoginDataRequiredException("Type username and password");
        }

        try {
            $this['api']->login($this['instagram.username'], $this['instagram.password']);
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
     * IDE Helper
     * @return User|Follow|Logger|Instagram|Like
     */
    public function offsetGet($id)
    {
        return parent::offsetGet($id);
    }
}
