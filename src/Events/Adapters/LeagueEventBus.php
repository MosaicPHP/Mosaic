<?php

namespace Mosaic\Events\Adapters;

use Mosaic\Contracts\Events\Bus;
use Mosaic\Events\AbstractBus;

class LeagueEventBus extends AbstractBus implements Bus
{
    /**
     * Immediately fire the event
     * @param string|object $event
     */
    public function fire($event)
    {
        // TODO: Implement fire() method.
    }
}
