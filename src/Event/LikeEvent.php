<?php

namespace Instapp\Event;

use InstagramAPI\Response\Model\Item;
use Symfony\Component\EventDispatcher\Event;

class LikeEvent extends Event
{
    const NAME = 'instapp.like.action';

    /** @var Item */
    public $item;

    /** @var bool */
    public $status;

    public function __construct(Item $item, $status)
    {
        $this->item = $item;
        $this->status = $status;
    }
}