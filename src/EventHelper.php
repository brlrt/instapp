<?php

namespace Instapp;

use Instapp\Exception\EventNotFoundException;

class EventHelper
{
    public static $events = [
        'logged'    => Event\LoggedEvent::NAME,
        'log'       => Event\LogEvent::NAME,
        'follow'    => Event\FollowEvent::NAME,
        'like'      => Event\LikeEvent::NAME,
    ];

    public static function get($name)
    {
        if (array_key_exists($name, self::$events))
            return self::$events[$name];

        throw new EventNotFoundException("Event \"{$name}\" not found");
    }
}