<?php

namespace Instapp\Provider;

use InstagramAPI\Instagram;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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