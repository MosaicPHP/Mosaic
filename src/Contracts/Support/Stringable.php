<?php

namespace Mosaic\Contracts\Support;

interface Stringable
{
    /**
     * Get the string representation of this object.
     *
     * @see https://secure.php.net/language.oop5.magic#object.tostring
     * @return string
     */
    public function __toString();
}
