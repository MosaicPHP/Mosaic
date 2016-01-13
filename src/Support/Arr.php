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

    /**
     * Unwraps a single item array into the item. If the array contains more than one item, it will be returned as-is.
     * A default value can be provided, and will be used when an empty array is given.
     *
     * @param array      $input
     * @param mixed|null $default
     *
     * @return mixed
     */
    public static function unwrap(array $input, $default = null)
    {
        if (count($input) > 1) {
            return $input;
        }

        return ! empty($input) ? current($input) : $default;
    }
}
