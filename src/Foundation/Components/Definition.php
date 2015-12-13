<?php

namespace Fresco\Foundation\Components;

interface Definition
{
    /**
     * @return object
     */
    public function define();

    /**
     * @return string
     */
    public function defineAs();
}
