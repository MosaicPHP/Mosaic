<?php

namespace Fresco\Support;

use Fresco\Contracts\Support\Stringable;

class HtmlString implements Stringable
{
    /**
     * @var string
     */
    private $string;

    /**
     * HtmlString constructor.
     *
     * @param $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * Get the string representation of this object.
     *
     * @see https://secure.php.net/language.oop5.magic#object.tostring
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }
}
