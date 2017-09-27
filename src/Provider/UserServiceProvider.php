<?php

namespace Instapp\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Instapp\Service\User;

class UserServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['user'] = function($app) {
            return new User($app);
        };
    }
}