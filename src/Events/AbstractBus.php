<?php

namespace Mosaic\Events;

abstract class AbstractBus
{
    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * Raise the event
     * @param string|object $event
     */
    public function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * Release all pending events
     */
    public function release()
    {
        foreach ($this->pendingEvents as $event) {
            $this->fire($event);
        }
    }

    /**
     * Immediately fire the event
     * @param string|object $event
     */
    abstract public function fire($event);
}
