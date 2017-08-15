<?php

namespace Instapp;

abstract class Macro
{
    /**
     * @var \Instapp\Instapp
     */
    protected $app;

    /**
     * MacroInterface constructor.
     * @param Instapp $app
     */
    public function __construct(\Instapp\Instapp $app)
    {
        $this->app = $app;
    }

    /**
     * Abstract.
     * @return bool
     */
    public function run() {}
}