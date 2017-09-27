<?php

namespace Instapp\Event;

use Symfony\Component\EventDispatcher\Event;

class LoggedEvent extends Event
{
    const NAME = 'instapp.logged';
}