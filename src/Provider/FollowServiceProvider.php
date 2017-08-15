<?php

namespace Instapp\Provider;

use Instapp\Service\Follow;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class FollowServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['follow'] = function($app) {
            return new Follow($app);
        };
    }
}