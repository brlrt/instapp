<?php

namespace Instapp\Traits;

trait Wait
{
    /**
     * @var int
     */
    public $waitTime = 20;

    protected function wait()
    {
        $this->app['logger']->add('...');
        sleep($this->waitTime);
    }
}