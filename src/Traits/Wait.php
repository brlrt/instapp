<?php

namespace Instapp\Traits;

trait Wait
{
    /**
     * @var int
     */
    public $waitTime = 5;

    protected function wait()
    {
        $this->app['logger']->add('...');
        sleep($this->waitTime);
    }
}