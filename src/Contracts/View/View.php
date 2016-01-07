<?php

namespace Fresco\Contracts\View;

interface View
{
    /**
     * @return string
     */
    public function render() : string;

    /**
     * Add a piece of data to the view.
     *
     * @param string|array $key
     * @param mixed        $value
     *
     * @return View
     */
    public function with($key, $value = null) : View;

    /**
     * @return array
     */
    public function getData() : array;

    /**
     * @return string
     */
    public function __toString() : string;
}
