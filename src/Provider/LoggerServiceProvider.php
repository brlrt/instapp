<?php

namespace Instapp\Provider;

use Instapp\Service\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LoggerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function() {
            return new Logger();
        };
    }
}