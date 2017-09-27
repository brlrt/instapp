<?php

namespace Instapp\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Instapp\Service\Logger;

class LoggerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function($app) {
            return new Logger($app);
        };
    }
}