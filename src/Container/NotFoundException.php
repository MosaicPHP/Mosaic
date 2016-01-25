<?php

namespace Fresco\Container;

use Interop\Container\Exception\NotFoundException as InteropNotFoundException;

class NotFoundException extends \InvalidArgumentException implements InteropNotFoundException
{
    public static function notBound($abstract)
    {
        return new static("Dependency [$abstract] could not be resolved.");
    }
}
