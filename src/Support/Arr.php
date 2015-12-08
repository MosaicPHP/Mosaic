<?php

namespace Fresco\Support;

class Arr
{
    /**
     * @param      $input
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public static function get($input, $key, $default = null)
    {
        if (array_key_exists($key, $input)) {
            return $input[$key];
        }

        return $default;
    }
}
