<?php

namespace Fresco\Support;

class Arr
{
    /**
     * @param mixed       $input
     * @param mixed       $key
     * @param string|null $default
     *
     * @return mixed
     */
    public static function get($input, $key, $default = null)
    {
        if (array_key_exists($key, $input)) {
            return $input[$key];
        }

        return $default;
    }
}
