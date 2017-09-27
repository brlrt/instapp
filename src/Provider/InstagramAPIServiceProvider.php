<?php

namespace Instapp\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use InstagramAPI\Instagram;

class InstagramAPIServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['api'] = function ($app) {
            $ig = new Instagram();
            return $ig;
        };
    }
}