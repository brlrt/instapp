<?php

namespace Instapp\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Instapp\Service\Follow;

class FollowServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['follow'] = function($app) {
            return new Follow($app);
        };
    }
}