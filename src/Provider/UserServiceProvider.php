<?php

namespace Instapp\Provider;

use Instapp\Service\User;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class UserServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['user'] = function($app) {
            return new User($app);
        };
    }
}