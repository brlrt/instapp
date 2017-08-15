<?php

namespace Instapp\Provider;

use Instapp\Service\Like;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LikeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['like'] = function($app) {
            return new Like($app);
        };
    }
}