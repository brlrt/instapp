<?php

namespace Instapp\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Instapp\Service\Like;

class LikeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['like'] = function($app) {
            return new Like($app);
        };
    }
}