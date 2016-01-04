<?php

namespace Fresco\Foundation\Components;

interface Definition
{
    /**
     * @return mixed
     */
    public function define();

    /**
     * @return string
     */
    public function defineAs() : string;
}
