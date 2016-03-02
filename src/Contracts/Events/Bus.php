<?php

namespace Fresco\Contracts\Events;

interface Bus
{
    /**
     * Immediately fire the event
     * @param string|object $event
     */
    public function fire($event);

    /**
     * Raise the event
     * @param string|object $event
     */
    public function raise($event);

    /**
     * Release all pending events
     */
    public function release();
}
