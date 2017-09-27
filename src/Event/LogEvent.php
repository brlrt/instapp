<?php

namespace Instapp\Event;

use Instapp\Service\Logger;
use Symfony\Component\EventDispatcher\Event;

class LogEvent extends Event
{
    const NAME = 'instapp.log';

    /** @var string */
    public $message;

    /** @var string Logger */
    public $type;

    public function __construct($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }
}