<?php

namespace Fresco\Events\Adapters;

use Fresco\Contracts\Events\Bus;
use Fresco\Events\AbstractBus;

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
